<?php


namespace App\Services;


use App\Models\Site;

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
        $this->docker_compose_service = new DockerComposeService();
        $this->reverse_proxy_service = new ReverseProxyService($this->site->name);
        $this->deployment_commands_service = new DeploymentCommandsService($this->site, $this->deploy_log_service);
    }

    public function firstDeploy() {
        $project_base_dir = PathHelper::getProjectBaseDir($this->site->user->email, $this->site->name);
        $this->createRequiredDirectories();
        $connection_info = ConnectionInfoGenerator::generate($this->site->name);

        SSHKeyService::generateKeyPair($this->site);

        $this->docker_compose_service->setConnectionInfo($connection_info);
        $this->docker_compose_service->newSiteContainer($this->site->name, $this->site->port, $project_base_dir);
        sleep(10); //wait until containers are ready
        if ($this->git_service->cloneRepo()) {
            $env_updater = new EnvVariablesService($this->git_service->source_dir, $this->site->name, $connection_info);
            $env_updater->updateEnv();
            $this->deployment_commands_service->runFirstDeployCommands();
            $this->deployment_commands_service->runDeployCommands();
            $this->deploy_log_service->write(true);
            $this->reverse_proxy_service->setupNginx($this->site->port);
        } else {
            $this->deploy_log_service->addLog("git clone " . $this->site->repo . " .", "Failed to clone the repository with the provided credentials");
            $this->deploy_log_service->write(false);
        }
    }

    public function reDeploy() {
        $project_base_dir = PathHelper::getProjectBaseDir($this->site->user->email, $this->site->name);

        // try pull. if there were any problems with pull, let's clone repo again
        if (!$this->git_service->pull()) {
            $this->git_service->cloneRepo();
        }
        $this->docker_compose_service->restart($this->site->name, $project_base_dir);
        sleep(10); //wait until containers are ready
        $deployment_commands_service = new DeploymentCommandsService($this->site, $this->deploy_log_service);
        $deployment_commands_service->runDeployCommands();
        $this->deploy_log_service->write(true);
        $this->reverse_proxy_service->setupNginx($this->site->port);
    }

    protected function createRequiredDirectories(){
        $repos_dir = config('larahost.repos_dir');
        $email = $this->site->user->email;
        $project_base_dir = PathHelper::getProjectBaseDir($email, $this->site->name);
        $source_dir = PathHelper::getSourceDir($email, $this->site->name);
        $deploy_logs_dir = PathHelper::getDeploymentLogsDir($email, $this->site->name);
        $docker_compose_dir = PathHelper::getDockerComposeDir($email, $this->site->name);
        $laravel_logs_dir = PathHelper::getLaravelLogsDir($email, $this->site->name);
        $ssh_keys_dir = PathHelper::getSSHKeysDir($email, $this->site->name);

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
        mkdir($laravel_logs_dir);
        mkdir($ssh_keys_dir);
    }
}
