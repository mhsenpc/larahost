<?php


namespace App\Services;


use App\Models\Deployment;
use Illuminate\Support\Facades\Log;

class DeployLogService {
    protected $commands_and_outputs = [];
    /**
     * @var \App\Models\Site
     */
    private $site;

    public function __construct(\App\Models\Site $site) {
        $this->site = $site;
    }

    public function addLog(string $command, $output) {
        if (is_array($output)) {
            $output = implode('\r\n', $output);
        }
        $this->commands_and_outputs[$command] = $output;
    }

    public function write(bool $success) {
        $dep_logs_dir = PathHelper::getDeploymentLogsDir($this->site->user->email, $this->site->name);
        $file_name = date('YmdHis') . '.log';
        file_put_contents($dep_logs_dir . '/' . $file_name, $this->getFormattedDeployLog());
        Deployment::create([
            'site_id' => $this->site->id,
            'log_file' => $file_name,
            'success' => $success
        ]);
    }

    protected function getFormattedDeployLog() {
        $result = "";
        foreach ($this->commands_and_outputs as $command => $output) {
            $result .= "root@" . $this->site->name . ":/var/www/html# " . $command . "\r\n";
            $result .= $output . "\r\n";
        }
        return $result;
    }

    public function clearReposPathFromOutput($output) {
        if (is_array($output)) {
            $output = implode('\r\n', $output);
        }

        $repos_dir = config('larahost.repos_dir');
        $output = str_replace("{$repos_dir}/{$this->site->user->email}/{$this->site->name}/source", '/var/www/html', $output);
        return $output;
    }
}
