<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DockerComposeService {
    protected $connection_info;

    public function setConnectionInfo(ConnectionInfo $connectionInfo) {
        $this->connection_info = $connectionInfo;
    }

    public function newSiteContainer(string $name, int $port, string $project_dir) {
        $compose_dir = $project_dir . '/' . config('larahost.dir_names.docker-compose');
        $this->writeComposeFile($name, $port, $project_dir);
        $output = SuperUserAPIService::compose_up($name, $compose_dir);
        Log::debug("output of compose up");
        Log::debug($output);
    }

    public function start(string $project_name, string $project_dir) {
        $docker_compose_dir = config('larahost.dir_names.docker-compose');
        $output = SuperUserAPIService::compose_up($project_name, $project_dir . '/' . $docker_compose_dir);
        Log::debug("docker compose start");
        Log::debug($output);
    }

    public function stop(string $project_name, string $project_dir) {
        $docker_compose_dir = config('larahost.dir_names.docker-compose');
        $output = SuperUserAPIService::compose_down($project_name, $project_dir . '/' . $docker_compose_dir);
        Log::debug("docker compose stop");
        Log::debug($output);
    }

    public function restart(string $project_name, string $project_dir) {
        $this->stop($project_name, $project_dir);
        $this->start($project_name, $project_dir);
    }

    /**
     * @param string $name
     * @param int $port
     * @param string $project_dir
     */
    public function writeComposeFile(string $name, int $port, string $project_dir) {
        $compose_dir = $project_dir . '/' . config('larahost.dir_names.docker-compose');
        $template = Storage::get('docker_compose.template');
        $template = str_replace('$project_name', $name, $template);
        $template = str_replace('$port', $port, $template);
        $template = str_replace('$db_password', $this->connection_info->db_password, $template);
        $template = str_replace('$source_dir', $project_dir . '/' . config('larahost.dir_names.source'), $template);
        $template = str_replace('$ssh_keys_dir', $project_dir . '/' . config('larahost.dir_names.ssh_keys'), $template);
        $template = str_replace('$db_dir', $project_dir . '/' . config('larahost.dir_names.db'), $template);
        file_put_contents($compose_dir . '/docker-compose.yml', $template);
    }
}
