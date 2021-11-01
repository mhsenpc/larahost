<?php

namespace App\Jobs;

use App\Events\Site\Deployed;
use App\Events\Site\Deploying;
use App\Services\ProgressService;
use App\Services\DeployService;
use App\Services\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RedeploySiteJob implements ShouldQueue {
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
        Deploying::dispatch($this->site->getModel());
        ProgressService::start("deploy_{$this->site->getName()}");
        $site_service = new DeployService($this->site);
        $site_service->reDeploy();
        Deployed::dispatch($this->site->getModel());
    }
}
