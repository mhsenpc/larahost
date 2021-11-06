<?php


namespace App\Services;


use App\Events\Site\Created;
use App\Events\Site\Deployed;

use App\Singleton\DeployLogger;
use Illuminate\Support\Facades\Log;

class DeployService {
    private $site;
    protected $docker_compose_service;
    protected $reverse_proxy_service;
    protected $deployment_commands_service;

    public function __construct(Site $site) {
        $this->site = $site;
        $this->docker_compose_service = new DockerComposeService($site->getModel());
        $this->reverse_proxy_service = new ReverseProxy($site->getModel());
        $this->deployment_commands_service = new DeploymentCommandsService($site->getModel());
    }

    public function firstDeploy() {
        Log::debug("first deploy");
        $this->site->getFilesystem()->createRequiredDirectories();
        $siteContainer =  $this->docker_compose_service->createContainer();
        if ($siteContainer->waitForWakeUp()) {
            $gitUser = $this->site->getModel()->git_user;
            $gitPass = $this->site->getModel()->git_password;
            $repoUrl = $this->site->getModel()->repo;
            if ($this->site->getRepository()->cloneRepo($repoUrl,$gitUser,$gitPass) ) {
                $this->site->getApplication()->initializeEnvVariables();
                $this->deployment_commands_service->runFirstDeployCommands();
                DeployLogger::write(true);
                $this->site->getDomain()->add( $this->site->getName() . '.lara-host.ir');
            } else {
                DeployLogger::addLog("git clone {$this->site->getModel()->repo} .", "Failed to clone the repository with the provided credentials");
                DeployLogger::write(false);
            }
        } else {
            DeployLogger::addLog("site new {$this->site->getName()}", "Unable to setup a new site. Contact Administrator");
            DeployLogger::write(false);
            Log::critical("failed to create new container {$this->site->getName()}");
        }
        $this->postDeploy();
    }

    public function reDeploy() {
        $repoUrl = $this->site->getModel()->repo;
        $gitUser = $this->site->getModel()->git_user;
        $gitPass = $this->site->getModel()->git_password;

        // try pull. if there were any problems with pull, let's clone repo again
        $valid_repo = $this->site->getRepository()->pull();
        if (!$valid_repo) {
            $valid_repo = $this->site->getRepository()->cloneRepo($repoUrl,$gitUser,$gitPass);
        }

        if ($valid_repo) {
            $deployment_commands_service = new DeploymentCommandsService($this->site->getModel());
            $deployment_commands_service->runDeployCommands();
            DeployLogger::write(true);
        }
        $this->postDeploy();
    }

    protected function postDeploy(){
        Created::dispatch($this->site->getModel());
        Deployed::dispatch($this->site->getModel());
    }
}
