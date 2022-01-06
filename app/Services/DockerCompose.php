<?php


namespace App\Services;


use App\Models\User;
use App\Singleton\ConnectionInfo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DockerCompose {
    protected $lines;
    private Filesystem $filesystem;
    private string $siteName;

    public function __construct(string $siteName, Filesystem $filesystem) {
        $this->lines = Storage::get('docker_compose.template');
        $this->siteName = $siteName;
        $this->filesystem = $filesystem;
    }

    /**
     * @param int $port
     */
    public function write(User $user, int $port) {
        $this->addProjectName()
            ->addPort($port)
            ->addDBPassword()
            ->addDirPaths($user);
        SuperUserAPIService::put_contents($this->filesystem->getDockerComposeDir() . '/docker-compose.yml', $this->lines);
    }

    protected function addDirPaths(User $user) {
        $this->lines = str_replace('$source_dir', $this->filesystem->getSourceDir(), $this->lines);
        $this->lines = str_replace('$ssh_keys_dir', $user->getSSHKeysDir(), $this->lines);
        $this->lines = str_replace('$workers_dir', $this->filesystem->getWorkersDir(), $this->lines);
        $this->lines = str_replace('$db_dir', $this->filesystem->getProjectBaseDir() . '/' . config('larahost.dir_names.db'), $this->lines);
        return $this;
    }

    protected function addDBPassword() {
        $connection_info = ConnectionInfo::getInstance($this->siteName);
        $this->lines = str_replace('$db_password', $connection_info->getDbPassword(), $this->lines);
        return $this;
    }

    protected function addPort(int $port) {
        $this->lines = str_replace('$port', $port, $this->lines);
        return $this;
    }

    protected function addProjectName() {
        $this->lines = str_replace('$project_name', $this->siteName, $this->lines);
        return $this;
    }

    public function execute() {
        $output = SuperUserAPIService::compose_up($this->siteName, $this->filesystem->getDockerComposeDir());
        Log::debug("output of new container");
        Log::debug($output);
    }
}
