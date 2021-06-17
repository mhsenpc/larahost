<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use Illuminate\Support\Facades\Storage;

class DockerService
{
    protected $binary = "/usr/bin/docker-compose";
    protected $connection_info;

    public function setConnectionInfo(ConnectionInfo $connectionInfo) {
        $this->connection_info = $connectionInfo;
    }

    public function newSiteContainer(string $name, int $port, string $project_dir) {
        $template = Storage::get('docker_compose.template');
        $template = str_replace('$project_name', $name, $template);
        $template = str_replace('$port', $port, $template);
        $template = str_replace('$db_password', $this->connection_info->db_password, $template);
        file_put_contents($project_dir . '/docker-compose.yml', $template);
        exec("cd $project_dir;{$this->binary} up -d", $output);
        \Log::debug("output of compose up");
        \Log::debug($output);
    }
}
