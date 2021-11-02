<?php


namespace App\Services;


use App\Contracts\ApplicationInterface;
use App\Contracts\FileSystemInterface;

class Laravel implements ApplicationInterface {
    private string $siteName;
    private Filesystem $fileSystem;
    private Supervisor $supervisor;

    public function __construct(string $siteName, FileSystemInterface $fileSystem, \App\Services\Supervisor $supervisor) {
        $this->siteName = $siteName;
        $this->fileSystem = $fileSystem;
        $this->supervisor = $supervisor;
    }

    public function getQueue(): Queue {
        return new Queue($this->siteName, $this->fileSystem->getWorkersDir(),$this->supervisor);
    }

    public function initializeEnvVariables(){
        $env = new  ENV($this->siteName,$this->fileSystem->getSourceDir());
        $env->initializeEnvVariables();
    }
}
