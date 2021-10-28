<?php

namespace App\Jobs;

use App\Events\SiteCreated;
use App\Events\SiteDeployed;
use App\Models\Site;
use App\Services\ConnectionInfoGenerator;
use App\Services\DeployLogService;
use App\Services\DockerComposeService;
use App\Services\EnvVariablesService;
use App\Services\GitService;
use App\Services\DeploymentCommandsService;
use App\Services\ProgressService;
use App\Services\ReverseProxyService;
use App\Services\DeployService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNewSiteJob implements ShouldQueue {
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
        ProgressService::start("create_{$this->site->name}");
        ProgressService::start("deploy_{$this->site->name}");
        $site_service = new DeployService($this->site);
        $site_service->firstDeploy();
        SiteCreated::dispatch($this->site);
        SiteDeployed::dispatch($this->site);
        ProgressService::finish("create_{$this->site->name}");
        ProgressService::finish("deploy_{$this->site->name}");
    }
}
