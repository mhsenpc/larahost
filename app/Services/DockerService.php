<?php


namespace App\Services;


class DockerService
{
    protected $binary = "docker";

    public function __construct() {
        if (config("app.env") == "local") {
            $this->binary = "dockerx";
        }
    }

    public function newLaravelContainer(string $name, int $port,string $project_dir) {
        exec( "{$this->binary} run -v $project_dir:/var/www/html --name=$name -d -p $port:80  bitnami/laravel:8");
    }

    protected function writeDockerCompose(){
        //TODO: write docker file and docker-compose up
    }
}
