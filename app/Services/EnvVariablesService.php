<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use Illuminate\Support\Facades\Storage;

class EnvVariablesService
{
    protected $connection_info;
    protected $env_path;
    private $project_name;

    public function __construct(string $project_dir, string $project_name, ConnectionInfo $connection_info) {
        $this->connection_info = $connection_info;
        $this->env_path        = $project_dir;
        $this->project_name    = $project_name;
        if (file_exists($project_dir . "/.env")) {
            // use their env in repo. however awkward it is
        } else if (file_exists($project_dir . "/.env.example")) {
            copy($project_dir . "/.env.example", $project_dir . "/.env");
        } else {
            // create default .env
            copy(Storage::path('defaultenv'), $project_dir . "/.env");
        }
        $this->env_path = $project_dir . "/.env";
    }

    public function updateEnv() {
        $env_editor = new DotEnvEditor($this->env_path);

        // app name
        $env_editor->changeKey('APP_NAME', $this->project_name);

        // db connection info
        $env_editor->changeKey('DB_CONNECTION', $this->connection_info->db_connection);
        $env_editor->changeKey('DB_HOST', $this->connection_info->db_host);
        $env_editor->changeKey('DB_PORT', $this->connection_info->db_port);
        $env_editor->changeKey('DB_DATABASE', $this->connection_info->db_name);
        $env_editor->changeKey('DB_USERNAME', $this->connection_info->db_username);
        $env_editor->changeKey('DB_PASSWORD', $this->connection_info->db_password);
        $env_editor->flush();
    }
}
