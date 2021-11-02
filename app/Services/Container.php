<?php


namespace App\Services;


use App\Contracts\ContainerInterface;
use Illuminate\Support\Facades\Log;

class Container implements ContainerInterface {
    private string $siteName;
    private \App\Contracts\FileSystemInterface $fileSystem;

    public function __construct(string $siteName, \App\Contracts\FileSystemInterface $fileSystem) {
        $this->siteName = $siteName;
        $this->fileSystem = $fileSystem;
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
}
