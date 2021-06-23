<?php


namespace App\Services;


use App\Models\Deployment;
use App\Models\Site;
use Illuminate\Support\Facades\Log;

class DeploymentCommandsService
{
    protected $binary = "/usr/bin/docker";

    /**
     * @var Site
     */
    private $site;
    /**
     * @var string
     */
    private $project_dir;

    protected $commands
        = [
            'chown -R www-data:www-data ./',
            'composer install',
            'php artisan key:generate',
            'php artisan migrate'
        ];

    public function __construct(Site $site, string $project_dir) {
        $this->site        = $site;
        $this->project_dir = $project_dir;
    }

    public function runCommands() {
        $file_contents = '';
        Log::debug("post run commands");
        foreach ($this->commands as $command) {
            exec("{$this->binary} exec {$this->site->name} $command 2>&1", $output);
            Log::debug($output);
            $file_contents .= implode('\r\n', $output);
        }
        $this->saveDeploymentLog($file_contents);
    }

    protected function saveDeploymentLog(string $log){
        $dep_logs_dir = $this->project_dir . '/deployment_logs';
        mkdir($dep_logs_dir);
        $file_name = date('YmdHis.log');
        file_put_contents($dep_logs_dir . '/' . $file_name, $log);
        Deployment::create([
            'site_id' => $this->site->id,
            'log_file' => $file_name,
            'success' => true //TODO: detect if any errors happened
        ]);
    }
}
