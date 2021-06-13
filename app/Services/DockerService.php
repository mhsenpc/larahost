<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class DockerService
{
    protected $binary = "/usr/bin/docker";
    protected $connection_info;

    public function __construct() {
        if (App::environment('local')) {
            $this->binary = "dockerx";
        }
    }

    public function setConnectionInfo(ConnectionInfo $connectionInfo) {
        $this->connection_info = $connectionInfo;
    }

    public function newLaravelContainer(string $name, int $port, string $project_dir) {
        Log::debug("trying to docker run $project_dir on port $port");
        $command = "{$this->binary} run --link={$this->connection_info->db_host} -v $project_dir:/var/www/html --name=$name -d -p $port:80  bitnami/laravel:8 2>&1";
        Log::debug($command);
        exec($command, $output, $return_var);
        return $output;
    }

    public function newDBContainer() {
        exec("{$this->binary} run --name={$this->connection_info->db_host} -e MYSQL_ROOT_PASSWORD={$this->connection_info->db_password} -e MYSQL_DATABASE={$this->connection_info->db_name} mariadb 2>&1", $output, $return_var);
        return $output;
    }
}
