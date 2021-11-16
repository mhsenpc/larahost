<?php


namespace App\Services;


use App\Contracts\ApplicationInterface;
use App\Contracts\FileSystemInterface;

class Laravel implements ApplicationInterface {
    private string $siteName;
    private Filesystem $fileSystem;
    private Supervisor $supervisor;
    private string $deployCommands;

    public function __construct(string $siteName, FileSystemInterface $fileSystem, Supervisor $supervisor, string $deployCommands) {
        $this->siteName = $siteName;
        $this->fileSystem = $fileSystem;
        $this->supervisor = $supervisor;
        $this->deployCommands = $deployCommands;
    }

    public function getQueue(): Queue {
        return new Queue($this->siteName, $this->fileSystem->getWorkersDir(), $this->supervisor);
    }

    protected function initializeEnvVariables() {
        $env = new  ENV($this->siteName, $this->fileSystem->getSourceDir());
        $env->initializeEnvVariables();
    }

    public function getEnvFile() {
        $env = '';
        if (file_exists($this->fileSystem->getSourceDir() . '/.env')) {
            $env = file_get_contents($this->fileSystem->getSourceDir() . '/.env');
        }
        return $env;
    }

    public function updateEnvFile(string $contents) {
        SuperUserAPIService::put_contents($this->fileSystem->getSourceDir() . '/.env', $contents);
        SuperUserAPIService::exec($this->siteName, 'php artisan config:clear');
    }

    public function getMaintenance(): Maintenance {
        return new Maintenance($this->siteName, $this->fileSystem->getSourceDir());
    }

    public function setup():CommandLog{
        $logs = (new LaravelDeployCommands($this->siteName,$this->deployCommands))->executeOneTimeCommands();
        $this->initializeEnvVariables();
        return $logs;
    }
}
