<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class DockerService
{
    protected $binary = "/usr/bin/docker";

    public function __construct() {
        if (config("app.env") == "local") {
            $this->binary = "dockerx";
        }
    }

    public function newLaravelContainer(string $name, int $port,string $project_dir) {
        Log::debug("trying to docker run $project_dir on port $port");
        exec( "{$this->binary} run -v $project_dir:/var/www/html --name=$name -d -p $port:80  bitnami/laravel:8 2>&1", $output, $return_var);
        Log::debug("output is ");
        Log::debug($output);
        Log::debug("return var is ");
        Log::debug($return_var);
    }

    protected function writeDockerCompose(){
        //TODO: write docker file and docker-compose up
    }
}
