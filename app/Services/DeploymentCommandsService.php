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

    public function __construct(Site $site) {
        $this->site = $site;
        $this->commands = preg_split("/\r\n|\n|\r/", $this->site->deploy_commands);
    }

    public function runCommands() {
        $file_contents = '';
        Log::debug("post run commands");
        foreach ($this->commands as $command) {
            $output = SuperUserAPIService::exec_command($this->site->name, $command);
            $output = json_decode($output);
            $output = $output->data;
            Log::debug($output);
            $file_contents .= $command . "\r\n";
            $file_contents .= $output . "\r\n";
        }
        $this->saveDeploymentLog($file_contents, true);
    }

    public function saveDeploymentLog(string $log, bool $success) {
        $dep_logs_dir = PathHelper::getDeploymentLogsDir($this->site->user->email, $this->site->name);
        if (!is_dir($dep_logs_dir)) {
            mkdir($dep_logs_dir);
        }
        $file_name = date('YmdHis') . '.log';
        file_put_contents($dep_logs_dir . '/' . $file_name, $log);
        Deployment::create([
            'site_id' => $this->site->id,
            'log_file' => $file_name,
            'success' => $success
        ]);
    }
}
