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

class RedeploySiteJob implements ShouldQueue
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
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // try git pull. git clone if there wasn't any files
        $git_service = new GitService($this->site);
        // try pull. if there were any problems with pull, let's clone repo again
        if(!$git_service->pull()){
            $git_service->cloneRepo();
        }
        $compose_service = new DockerComposeService();
        $compose_service->restart($this->site->name, $git_service->project_base_dir);
        sleep(10); //wait until containers are ready
        $deployment_commands_service = new DeploymentCommandsService($this->site);
        $deployment_commands_service->runCommands();
        $reverse_proxy_service = new ReverseProxyService($this->site->name);
        $reverse_proxy_service->setupNginx($this->site->port);
    }
}
