<?php


namespace App\Services;


use App\Models\Deployment;
use App\Models\Site;
use App\Singleton\DeployLogger;
use Illuminate\Support\Facades\Log;

class DeploymentCommandsService {
    /**
     * @var Site
     */
    protected $site;

    protected $commands = [];

    protected $deployLogger;

    public function __construct(Site $site) {
        $this->site = $site;
        $this->commands = preg_split("/\r\n|\n|\r/", $this->site->deploy_commands);
        $this->deployLogger = DeployLogger::getInstance($this->site);
    }

    public function runDeployCommands() {
        Log::debug("runDeployCommands");
        foreach ($this->commands as $command) {
            $output = SuperUserAPIService::exec($this->site->name, $command);
            $this->deployLogger->addLog($command, $output['data']);
            Log::debug($output['data']);
        }
    }

    public function runFirstDeployCommands() {
        Log::debug("first deploy commands");

        $output = SuperUserAPIService::exec($this->site->name, 'rm composer.lock');
        Log::debug($output);

        $this->runDeployCommands();

        $output = SuperUserAPIService::exec($this->site->name, 'chown -R www-data:www-data ./');
        Log::debug($output);

        $output = SuperUserAPIService::exec($this->site->name, 'php artisan storage:link');
        Log::debug($output);

        $output = SuperUserAPIService::exec($this->site->name, 'php artisan key:generate');
        Log::debug($output);
    }
}
