<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DockerComposeService
{
    protected $binary = "/usr/bin/docker-compose";
    protected $connection_info;

    public function setConnectionInfo(ConnectionInfo $connectionInfo) {
        $this->connection_info = $connectionInfo;
    }

    public function newSiteContainer(string $name, int $port, string $project_dir) {
        $template    = Storage::get('docker_compose.template');
        $template    = str_replace('$project_name', $name, $template);
        $template    = str_replace('$port', $port, $template);
        $template    = str_replace('$db_password', $this->connection_info->db_password, $template);
        $template    = str_replace('$source_dir', $project_dir . '/source', $template);
        $template    = str_replace('$db_dir', $project_dir . '/db', $template);
        $compose_dir = $project_dir . '/docker-compose';
        mkdir($compose_dir);
        file_put_contents($compose_dir . '/docker-compose.yml', $template);
        exec("cd $compose_dir;{$this->binary} --project-name {$name} up -d", $output);
        Log::debug("output of compose up");
        Log::debug($output);
    }

    public function start(string $project_name, string $project_dir) {
        exec("cd {$project_dir}/docker-compose;{$this->binary} --project-name $project_name up -d", $output);
        Log::debug("cd {$project_dir}/docker-compose;{$this->binary} up -d");
        Log::debug("docker compose start");
        Log::debug($output);
    }

    public function stop(string $project_dir) {
        exec("cd {$project_dir}/docker-compose;{$this->binary} down", $output);
        Log::debug("docker compose stop");
        Log::debug($output);
    }

    public function restart(string $project_name, string $project_dir) {
        $this->stop($project_dir);
        $this->start($project_name, $project_dir);
    }
}
