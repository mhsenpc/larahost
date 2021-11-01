<?php


namespace App\Services;


use App\Events\Site\Created;
use App\Events\Site\Deployed;
use App\Models\Site;
use Illuminate\Support\Facades\Log;

class DeployService {
    /**
     * @var Site
     */
    private $site;

    protected $deploy_log_service;
    protected $git_service;
    protected $docker_compose_service;
    protected $reverse_proxy_service;
    protected $deployment_commands_service;

    public function __construct(Site $site) {
        $this->site = $site;
        $this->deploy_log_service = new DeployLogService($this->site);
        $this->git_service = new GitService($this->site, $this->deploy_log_service);
        $this->docker_compose_service = new DockerComposeService($this->site);
        $this->reverse_proxy_service = new ReverseProxyService($this->site);
        $this->deployment_commands_service = new DeploymentCommandsService($this->site, $this->deploy_log_service);
    }

    public function firstDeploy() {
        Log::debug("first deploy");
        $this->createRequiredDirectories($this->site);
        $this->docker_compose_service->newSiteContainer();
        if ($this->waitForWakeUp()) {
            if ($this->git_service->cloneRepo()) {
                $env_updater = new EnvVariablesService($this->site->getSourceDir() , $this->site->name);
                $env_updater->updateEnv();
                $this->deployment_commands_service->runFirstDeployCommands();
                $this->deploy_log_service->write(true);
                $this->reverse_proxy_service->writeNginxConfigs();
            } else {
                $this->deploy_log_service->addLog("git clone {$this->site->repo} .", "Failed to clone the repository with the provided credentials");
                $this->deploy_log_service->write(false);
            }
        } else {
            $this->deploy_log_service->addLog("site new {$this->site->name}", "Unable to setup a new site. Contact Administrator");
            $this->deploy_log_service->write(false);
            Log::critical("failed to create new container {$this->site->name}");
        }
        $this->postDeploy();
    }

    public function reDeploy() {
        // try pull. if there were any problems with pull, let's clone repo again
        $valid_repo = $this->git_service->pull();
        if (!$valid_repo) {
            $valid_repo = $this->git_service->cloneRepo();
        }

        if ($valid_repo) {
            $deployment_commands_service = new DeploymentCommandsService($this->site, $this->deploy_log_service);
            $deployment_commands_service->runDeployCommands();
            $this->deploy_log_service->write(true);
            $this->reverse_proxy_service->writeNginxConfigs();
        }
        $this->postDeploy();
    }

    protected function postDeploy(){
        Created::dispatch($this->site);
        Deployed::dispatch($this->site);
    }

    protected function waitForWakeUp() {
        $i = 0;
        while (!SuperUserAPIService::exec($this->site->name, "ls")['success']) {
            $i++;
            sleep(2000);
            if ($i > 30) {
                return false;
            }
        }
        return true;
    }

    public static function createRequiredDirectories(Site $site) {
        $repos_dir = config('larahost.repos_dir');

        /*
         * check if required directories exist
         */
        if (!is_dir($repos_dir)) {
            SuperUserAPIService::new_folder($repos_dir);
        }
        if (!is_dir($repos_dir . '/' . $site->user->email)) {
            SuperUserAPIService::new_folder($repos_dir . '/' . $site->user->email);
        }

        SuperUserAPIService::new_folder($site->getProjectBaseDir());
        SuperUserAPIService::new_folder($site->getSourceDir());
        SuperUserAPIService::new_folder($site->getDeploymentLogsDir());
        SuperUserAPIService::new_folder($site->getDockerComposeDir());
        SuperUserAPIService::new_folder($site->getWorkersDir());
    }
}
