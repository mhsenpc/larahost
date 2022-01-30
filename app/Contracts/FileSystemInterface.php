<?php


namespace App\Contracts;


interface FileSystemInterface {
    public function createRequiredDirectories();
    public function getProjectBaseDir();
    public function getDeploymentLogsDir();
    public function getSourceDir();
    public function getDockerComposeDir();
}
