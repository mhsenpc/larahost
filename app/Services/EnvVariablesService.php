<?php


namespace App\Services;


use App\Classes\ConnectionInfo;
use Illuminate\Support\Facades\Storage;

class EnvVariablesService
{
    protected $env_path;
    private  $site_name;

    public function __construct(string $source_dir, string $site_name) {
        $this->env_path        = $source_dir;
        $this->site_name    = $site_name;
        $envContent = '';
        if (file_exists($source_dir . "/.env")) {
            // use their env in repo. however awkward it is
        } else if (file_exists($source_dir . "/.env.example")) {
            $envContent = file_get_contents($source_dir . "/.env.example");
        } else {
            // create default .env
            copy(Storage::path('env.template'), $source_dir . "/.env");
            $envContent = Storage::get('env.template');
        }
        if($envContent){
            SuperUserAPIService::put_contents($source_dir . "/.env",$envContent);
        }
        $this->env_path = $source_dir . "/.env";
    }

    public function updateEnv() {
        $env_editor = new DotEnvEditor($this->env_path);
        $connection_info = ConnectionInfo::getInstance($this->site_name);

        // app name
        $env_editor->changeKey('APP_NAME', $this->site_name);

        $env_editor->changeKey('APP_URL', "http://{$this->site_name}.lara-host.ir");

        // db connection info
        $env_editor->changeKey('DB_CONNECTION', $connection_info->getDbConnection());
        $env_editor->changeKey('DB_HOST', $connection_info->getDbHost());
        $env_editor->changeKey('DB_PORT', $connection_info->getDbPort());
        $env_editor->changeKey('DB_DATABASE', $connection_info->getDbName());
        $env_editor->changeKey('DB_USERNAME', $connection_info->getDbUsername());
        $env_editor->changeKey('DB_PASSWORD', $connection_info->getDbPassword());
        $env_editor->changeKey('CACHE_DRIVER', 'redis');
        $env_editor->changeKey('SESSION_DRIVER', 'redis');
        $env_editor->changeKey('REDIS_HOST', "{$this->site_name}_redis");
        $env_editor->flush();
    }
}
