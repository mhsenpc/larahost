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
    protected $project_base_dir;
    protected $project_compose_dir;
    protected $user_keys_dir;


    public function __construct(Site $site) {
        $this->site = $site;
        $this->project_base_dir = PathHelper::getProjectBaseDir($this->site->user->email, $this->site->name);
        $this->project_compose_dir = PathHelper::getDockerComposeDir($this->site->user->email, $this->site->name);
        $this->user_keys_dir = PathHelper::getSSHKeysDir($this->site->user->email);
    }

    public function setConnectionInfo(ConnectionInfo $connectionInfo) {
        $this->connection_info = $connectionInfo;
    }

    public function newSiteContainer() {
        $this->writeComposeFile($this->site->name, $this->site->port, $this->project_base_dir);
        $output = SuperUserAPIService::compose_up($this->site->name, $this->project_compose_dir);
        Log::debug("output of compose up");
        Log::debug($output);
    }

    public function start() {
        $output = SuperUserAPIService::compose_up($this->site->name, $this->project_compose_dir);
        Log::debug("docker compose start");
        Log::debug($output);
    }

    public function stop() {
        $output = SuperUserAPIService::compose_down($this->site->name, $this->project_compose_dir);
        Log::debug("docker compose stop");
        Log::debug($output);
    }

    public function restart() {
        $this->stop();
        $this->start();
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
        $template = str_replace('$source_dir', $project_dir . '/' . config('larahost.dir_names.source'), $template);
        $template = str_replace('$ssh_keys_dir', $this->user_keys_dir, $template);
        $template = str_replace('$db_dir', $project_dir . '/' . config('larahost.dir_names.db'), $template);
        file_put_contents($this->project_compose_dir . '/docker-compose.yml', $template);
    }
}
