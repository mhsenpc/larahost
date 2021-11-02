<?php


namespace App\Singleton;

use App\Models\Deployment;
use App\Services\SuperUserAPIService;

class DeployLogger {
    protected static $commands_and_outputs = [];
    /**
     * @var \App\Models\Site
     */
    private static $site;

    private static $instance;

    private function __construct() {
    }

    public static function getInstance(\App\Models\Site $site) {
        if (!self::$instance) {
            self::$site = $site;
            self::$instance = new DeployLogger();
        }
        return self::$instance;
    }

    public static function addLog(string $command, $output) {
        if (is_array($output)) {
            $output = implode('\r\n', $output);
        }
        self::$commands_and_outputs[$command] = $output;
    }

    public static function write(bool $success) {
        $dep_logs_dir = self::$site->getDeploymentLogsDir();
        $file_name = date('YmdHis') . '.log';
        SuperUserAPIService::put_contents($dep_logs_dir . '/' . $file_name, self::getFormattedDeployLog());
        Deployment::create([
            'site_id' => self::$site->id,
            'log_file' => $file_name,
            'success' => $success
        ]);
    }

    protected static function getFormattedDeployLog() {
        $result = "";
        foreach (self::$commands_and_outputs as $command => $output) {
            $result .= "root@" . self::$site->name . ":/var/www/html# " . $command . "\r\n";
            $result .= $output . "\r\n";
        }
        return $result;
    }

    public static function clearReposPathFromOutput($output) {
        if (is_array($output)) {
            $output = implode('\r\n', $output);
        }

        $repos_dir = config('larahost.repos_dir');
        $output = str_replace("{$repos_dir}/{self::$site->user->email}/{self::$site->name}/source", '/var/www/html', $output);
        return $output;
    }
}
