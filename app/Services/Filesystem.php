<?php


namespace App\Services;


use App\Contracts\FileSystemInterface;

class Filesystem implements FileSystemInterface {

    private string $userDir;
    private string $siteName;

    public function __construct(string $userDir, string $siteName) {
        $this->userDir = $userDir;
        $this->siteName = $siteName;
    }

    public function getProjectBaseDir() {
        if (empty(config('larahost.repos_dir')))
            throw new \Exception('Repos dir is not defined');

        return config('larahost.repos_dir') . '/' . $this->userDir . '/' .$this->siteName;
    }

    public function getDockerComposeDir() {
        return $this->getProjectBaseDir() . '/' . config('larahost.dir_names.docker-compose');
    }

    public function getSourceDir() {
        return $this->getProjectBaseDir() . '/' . config('larahost.dir_names.source');
    }

    public function getDeploymentLogsDir() {
        return $this->getProjectBaseDir() . '/' . config('larahost.dir_names.deployment_logs');
    }

    public function getLaravelLogsDir() {
        return $this->getSourceDir() . '/' . config('larahost.dir_names.laravel_logs');
    }

    public function getWorkersDir() {
        return $this->getProjectBaseDir() . '/' . config('larahost.dir_names.workers');
    }

    public function createRequiredDirectories() {
        $repos_dir = config('larahost.repos_dir');

        /*
         * check if required directories exist
         */
        if (!is_dir($repos_dir)) {
            SuperUserAPIService::new_folder($repos_dir);
        }
        if (!is_dir($repos_dir . '/' . $this->userDir)) {
            SuperUserAPIService::new_folder($repos_dir . '/' . $this->userDir);
        }

        SuperUserAPIService::new_folder($this->getProjectBaseDir());
        SuperUserAPIService::new_folder($this->getSourceDir());
        SuperUserAPIService::new_folder($this->getDeploymentLogsDir());
        SuperUserAPIService::new_folder($this->getDockerComposeDir());
        SuperUserAPIService::new_folder($this->getWorkersDir());
    }
}
