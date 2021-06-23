<?php

namespace App\Jobs;

use App\Models\Site;
use App\Services\ConnectionInfoGenerator;
use App\Services\DockerComposeService;
use App\Services\EnvVariablesService;
use App\Services\GitService;
use App\Services\DeploymentCommandsService;
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
     * @var Site
     */
    private $site;

    /**
     * Create a new job instance.
     *
     * @param Site $site
     */
    public function __construct(Site $site) {
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $connection_info = ConnectionInfoGenerator::generate($this->site->name);
        $git_service     = new GitService();
        $git_service->cloneRepo($this->site->user->email, $this->site->name, $this->site->repo);
        $env_updater = new EnvVariablesService($git_service->source_dir, $this->site->name, $connection_info);
        $env_updater->updateEnv();
        $docker_service = new DockerComposeService();
        $docker_service->setConnectionInfo($connection_info);
        $docker_service->newSiteContainer($this->site->name, $this->site->port, $git_service->project_base_dir);
        $deployment_commands_service = new DeploymentCommandsService($this->site, $git_service->project_base_dir);
        $deployment_commands_service->runCommands();
        $reverse_proxy_service = new ReverseProxyService($this->site->name);
        $reverse_proxy_service->setupNginx($this->site->port);
    }
}
