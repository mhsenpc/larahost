<?php


namespace App\Services;


use App\Contracts\ContainerInterface;
use App\Contracts\FileSystemInterface;
use App\Exceptions\WakeUpTimedOutException;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Container implements ContainerInterface {
    private string $siteName;
    private FileSystemInterface $fileSystem;

    public function __construct(string $siteName, FileSystemInterface $fileSystem) {
        $this->siteName = $siteName;
        $this->fileSystem = $fileSystem;
    }

    public function create(User $user,int $port): Container {
        $compose = new DockerCompose($this->siteName, $this->fileSystem);
        $compose->write($user, $port);
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
        for ($i = 0; $i < $maxTries; $i++) {
            $result = !SuperUserAPIService::exec($this->siteName, "ls -la")['success'];
            if($result){
                return true;
            }
            sleep(1);
        }
        throw new WakeUpTimedOutException();
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
