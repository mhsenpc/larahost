<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use Illuminate\Support\Facades\Storage;

class EnvVariablesService
{
    protected $connection_info;
    protected $env_path;
    private $site_name;

    public function __construct(string $source_dir, string $site_name, ConnectionInfo $connection_info) {
        $this->connection_info = $connection_info;
        $this->env_path        = $source_dir;
        $this->site_name    = $site_name;
        if (file_exists($source_dir . "/.env")) {
            // use their env in repo. however awkward it is
        } else if (file_exists($source_dir . "/.env.example")) {
            copy($source_dir . "/.env.example", $source_dir . "/.env");
        } else {
            // create default .env
            copy(Storage::path('env.template'), $source_dir . "/.env");
        }
        $this->env_path = $source_dir . "/.env";
    }

    public function updateEnv() {
        $env_editor = new DotEnvEditor($this->env_path);

        // app name
        $env_editor->changeKey('APP_NAME', $this->site_name);

        $env_editor->changeKey('APP_URL', "http://{$this->site_name}.gnulover.ir");

        // db connection info
        $env_editor->changeKey('DB_CONNECTION', $this->connection_info->db_connection);
        $env_editor->changeKey('DB_HOST', $this->connection_info->db_host);
        $env_editor->changeKey('DB_PORT', $this->connection_info->db_port);
        $env_editor->changeKey('DB_DATABASE', $this->connection_info->db_name);
        $env_editor->changeKey('DB_USERNAME', $this->connection_info->db_username);
        $env_editor->changeKey('DB_PASSWORD', $this->connection_info->db_password);
        $env_editor->changeKey('CACHE_DRIVER', 'redis');
        $env_editor->changeKey('SESSION_DRIVER', 'redis');
        $env_editor->changeKey('REDIS_HOST', "{$this->site_name}_redis");
        $env_editor->flush();
    }
}
