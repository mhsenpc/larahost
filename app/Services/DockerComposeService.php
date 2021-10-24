<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use App\Models\Site;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DockerComposeService {
    protected $connection_info;
    /**
     * @var Site
     */
    private $site;


    public function __construct(Site $site) {
        $this->site = $site;
    }

    public function setConnectionInfo(ConnectionInfo $connectionInfo) {
        $this->connection_info = $connectionInfo;
    }

    public function newSiteContainer() {
        $this->writeComposeFile($this->site->name, $this->site->port, $this->site->getProjectBaseDir());
        $output = SuperUserAPIService::compose_up($this->site->name, $this->site->getDockerComposeDir());
        Log::debug("output of compose up");
        Log::debug($output);
    }

    public function up() {
        $output = SuperUserAPIService::compose_up($this->site->name, $this->site->getDockerComposeDir());
        Log::debug("docker compose start");
        Log::debug($output);
    }

    public function down() {
        $output = SuperUserAPIService::compose_down($this->site->name, $this->site->getDockerComposeDir());
        Log::debug("docker compose stop");
        Log::debug($output);
    }

    public function rebuildContainers() {
        $this->down();
        $this->up();
    }

    /**
     * @param string $name
     * @param int $port
     * @param string $project_dir
     */
    public function writeComposeFile(string $name, int $port, string $project_dir) {
        $template = Storage::get('docker_compose.template');
        $template = str_replace('$project_name', $name, $template);
        $template = str_replace('$port', $port, $template);
        $template = str_replace('$db_password', $this->connection_info->db_password, $template);
        $template = str_replace('$source_dir', $this->site->getSourceDir(), $template);
        $template = str_replace('$ssh_keys_dir', $this->site->user->getSSHKeysDir(), $template);
        $template = str_replace('$workers_dir', $this->site->getWorkersDir(), $template);
        $template = str_replace('$db_dir', $project_dir . '/' . config('larahost.dir_names.db'), $template);
        file_put_contents($this->site->getDockerComposeDir() . '/docker-compose.yml', $template);
    }
}
