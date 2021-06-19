<?php

namespace App\Jobs;

use App\Services\ConnectionInfoGenerator;
use App\Services\DockerComposeService;
use App\Services\EnvVariablesService;
use App\Services\GitService;
use App\Services\PostCreationCommandsService;
use App\Services\ReverseProxyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNewSiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $repo_url;
    /**
     * @var int
     */
    private $port;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $name
     * @param string $repo_url
     * @param int $port
     */
    public function __construct(string $email, string $name, string $repo_url, int $port) {
        $this->email    = $email;
        $this->name     = $name;
        $this->repo_url = $repo_url;
        $this->port     = $port;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $connection_info = ConnectionInfoGenerator::generate($this->name);
        $project_dir     = GitService::cloneRepo($this->email, $this->name, $this->repo_url);
        $env_updater     = new EnvVariablesService($project_dir, $this->name, $connection_info);
        $env_updater->updateEnv();
        $docker_service = new DockerComposeService();
        $docker_service->setConnectionInfo($connection_info);
        $docker_service->newSiteContainer($this->name, $this->port, $project_dir);
        $post_creation_service = new PostCreationCommandsService($this->name, $project_dir);
        $post_creation_service->runCommands();
        $reverse_proxy_service = new ReverseProxyService($this->name, $this->port);
        $reverse_proxy_service->setupNginx();
    }
}
