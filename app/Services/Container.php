<?php


namespace App\Services;


use App\Contracts\ContainerInterface;
use App\Contracts\FileSystemInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Container implements ContainerInterface {
    private string $siteName;
    private FileSystemInterface $fileSystem;

    public function __construct(string $siteName, FileSystemInterface $fileSystem) {
        $this->siteName = $siteName;
        $this->fileSystem = $fileSystem;
    }

    public function create(int $port): Container {
        $compose = new DockerCompose($this->siteName, $this->fileSystem);
        $compose->write($port);
        $compose->execute();
        return $this;
    }

    public function rebuildContainers() {
        $this->down();
        $this->up();
    }

    public function up() {
        $output = SuperUserAPIService::compose_up($this->siteName, $this->fileSystem->getDockerComposeDir());
        Log::debug("docker compose start");
        Log::debug($output);
    }

    public function down() {
        $output = SuperUserAPIService::compose_down($this->siteName, $this->fileSystem->getDockerComposeDir());
        Log::debug("docker compose stop");
        Log::debug($output);
    }

    public function waitForWakeUp(int $maxTries = 30) {
        $i = 0;
        while (!SuperUserAPIService::exec($this->siteName, "ls")['success']) {
            $i++;
            sleep(2);
            if ($i > $maxTries) {
                return false;
            }
        }
        return true;
    }

    public function getSupervisor(): Supervisor {
        return new Supervisor($this->siteName);
    }

    public function isRunning(): bool {
        if (App::environment('local'))
            return true;
        $info = SuperUserAPIService::inspect($this->siteName);
        if ($info['success']) {
            $data = json_decode($info['data']);
            return $data[0]->State->Status == "running";
        } else {
            return false;
        }
    }
}
