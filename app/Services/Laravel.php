<?php


namespace App\Services;


use App\Contracts\ApplicationInterface;
use App\Contracts\FileSystemInterface;

class Laravel implements ApplicationInterface {
    private string $siteName;
    private Filesystem $fileSystem;

    public function __construct(string $siteName, FileSystemInterface $fileSystem) {
        $this->siteName = $siteName;
        $this->fileSystem = $fileSystem;
    }

    public function getQueue(): Queue {
        return new Queue($this->siteName, $this->fileSystem->getWorkersDir());
    }

    public function initializeEnvVariables(){
        $env = new  ENV($this->siteName,$this->fileSystem->getSourceDir());
        $env->initializeEnvVariables();
    }
}
