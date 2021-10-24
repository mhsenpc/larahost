<?php


namespace App\Services;


use App\Models\Deployment;
use App\Models\Site;
use Illuminate\Support\Facades\Log;

class DeploymentCommandsService {
    /**
     * @var Site
     */
    protected $site;

    protected $commands = [];
    /**
     * @var DeployLogService
     */
    protected $deploy_log_service;

    public function __construct(Site $site, DeployLogService $deploy_log_service) {
        $this->site = $site;
        $this->commands = preg_split("/\r\n|\n|\r/", $this->site->deploy_commands);
        $this->deploy_log_service = $deploy_log_service;
    }

    public function runDeployCommands() {
        Log::debug("runDeployCommands");
        foreach ($this->commands as $command) {
            $output = SuperUserAPIService::exec_command($this->site->name, $command);
            $this->deploy_log_service->addLog($command, $output['data']);
            Log::debug($output['data']);
        }
    }

    public function runFirstDeployCommands() {
        Log::debug("first deploy commands");

        $output = SuperUserAPIService::exec_command($this->site->name, 'rm composer.lock');
        Log::debug($output);

        $this->runDeployCommands();

        $output = SuperUserAPIService::exec_command($this->site->name, 'chown -R www-data:www-data ./');
        Log::debug($output);

        $output = SuperUserAPIService::exec_command($this->site->name, 'php artisan storage:link');
        Log::debug($output);

        $output = SuperUserAPIService::exec_command($this->site->name, 'php artisan key:generate');
        Log::debug($output);
    }
}
