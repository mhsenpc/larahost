<?php


namespace App\Services;

use App\Models\Deployment;

class LogWriter {
    protected int $siteId;
    protected string $deploymentLogsDir;

    public function __construct(int $siteId, string $deploymentLogsDir) {
        $this->siteId = $siteId;
        $this->deploymentLogsDir = $deploymentLogsDir;
    }

    public function write(CommandLog $commandLog, bool $success) {
        $file_name = date('YmdHis') . '.log';
        SuperUserAPIService::put_contents($this->deploymentLogsDir . '/' . $file_name, $commandLog->getFormattedLog());
        Deployment::create([
            'site_id' => $this->siteId,
            'log_file' => $file_name,
            'success' => $success
        ]);
    }
}
