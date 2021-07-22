<?php


namespace App\Services;


use App\Models\Deployment;
use App\Models\Site;
use Illuminate\Support\Facades\Log;

class DeploymentCommandsService {
    /**
     * @var Site
     */
    private $site;

    protected $commands = [];
    /**
     * @var DeployLogService
     */
    protected $deploy_log_service;

    public function __construct(Site $site, \App\Services\DeployLogService $deploy_log_service) {
        $this->site = $site;
        $this->commands = preg_split("/\r\n|\n|\r/", $this->site->deploy_commands);
        $this->deploy_log_service = $deploy_log_service;
    }

    public function runCommands() {
        Log::debug("post run commands");
        foreach ($this->commands as $command) {
            $output = SuperUserAPIService::exec_command($this->site->name, $command);
            $output = json_decode($output);
            $output = $output->data;
            $this->deploy_log_service->addLog($command,$output);
            Log::debug($output);
        }
    }
}
