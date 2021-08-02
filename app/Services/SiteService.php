<?php


namespace App\Services;


use App\Models\Site;
use Illuminate\Support\Facades\Log;

class SiteService {
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
        $this->createRequiredDirectories();
        $connection_info = ConnectionInfoGenerator::generate($this->site->name);

        $this->docker_compose_service->setConnectionInfo($connection_info);
        $this->docker_compose_service->newSiteContainer();
        if ($this->waitForWakeUp()) {
            if ($this->git_service->cloneRepo()) {
                $env_updater = new EnvVariablesService($this->git_service->source_dir, $this->site->name, $connection_info);
                $env_updater->updateEnv();
                $this->deployment_commands_service->runDeployCommands();
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
    }

    public function reDeploy() {
        // try pull. if there were any problems with pull, let's clone repo again
        $valid_repo = $this->git_service->pull();
        if (!$valid_repo) {
            $valid_repo = $this->git_service->cloneRepo();
        }

        if ($valid_repo) {
            $this->docker_compose_service->restart();
            if ($this->waitForWakeUp()) {
                $deployment_commands_service = new DeploymentCommandsService($this->site, $this->deploy_log_service);
                $deployment_commands_service->runDeployCommands();
                $this->deploy_log_service->write(true);
                $this->reverse_proxy_service->writeNginxConfigs();
            }
            else{
                Log::critical("failed to restart container {$this->site->name} while redeploy");
            }
        }
    }

    protected function createRequiredDirectories() {
        $repos_dir = config('larahost.repos_dir');
        $email = $this->site->user->email;
        $project_base_dir = PathHelper::getProjectBaseDir($email, $this->site->name);
        $source_dir = PathHelper::getSourceDir($email, $this->site->name);
        $deploy_logs_dir = PathHelper::getDeploymentLogsDir($email, $this->site->name);
        $docker_compose_dir = PathHelper::getDockerComposeDir($email, $this->site->name);

        /*
         * check if required directories exist
         */
        if (!is_dir($repos_dir)) {
            mkdir($repos_dir);
        }
        if (!is_dir($repos_dir . '/' . $email)) {
            mkdir($repos_dir . '/' . $email);
        }

        mkdir($project_base_dir);
        mkdir($source_dir);
        mkdir($deploy_logs_dir);
        mkdir($docker_compose_dir);
    }

    protected function waitForWakeUp() {
        $i = 0;
        while (!SuperUserAPIService::exec_command($this->site->name, "ls")['success']) {
            $i++;
            sleep(2000);
            if ($i > 30) {
                return false;
            }
        }
        return true;
    }
}
