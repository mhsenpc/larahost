<?php


namespace App\Services;


use App\Singleton\ConnectionInfo;
use Illuminate\Support\Facades\Storage;

class ENV {
    private string $siteName;
    private string $sourceDir;

    public function __construct(string $siteName, string $sourceDir) {
        $this->siteName = $siteName;
        $this->sourceDir = $sourceDir;
    }

    public function initializeEnvVariables(){
        $sourceDir = $this->sourceDir;
        $envContent = '';
        if (file_exists($sourceDir . "/.env")) {
            // use their env in repo. however awkward it is
        } else if (file_exists($sourceDir . "/.env.example")) {
            $envContent = file_get_contents($sourceDir . "/.env.example");
        } else {
            // create default .env
            copy(Storage::path('env.template'), $sourceDir . "/.env");
            $envContent = Storage::get('env.template');
        }
        if($envContent){
            SuperUserAPIService::put_contents($sourceDir . "/.env",$envContent);
        }

        $this->updateEnv();
    }

    protected function updateEnv() {
        $envPath = $this->sourceDir.'/.env';
        $env_editor = new DotEnvEditor($envPath);
        $connection_info = ConnectionInfo::getInstance($this->siteName);

        // app name
        $env_editor->changeKey('APP_NAME', $this->siteName);

        $env_editor->changeKey('APP_URL', "http://{$this->siteName}.lara-host.ir");

        // db connection info
        $env_editor->changeKey('DB_CONNECTION', $connection_info->getDbConnection());
        $env_editor->changeKey('DB_HOST', $connection_info->getDbHost());
        $env_editor->changeKey('DB_PORT', $connection_info->getDbPort());
        $env_editor->changeKey('DB_DATABASE', $connection_info->getDbName());
        $env_editor->changeKey('DB_USERNAME', $connection_info->getDbUsername());
        $env_editor->changeKey('DB_PASSWORD', $connection_info->getDbPassword());
        $env_editor->changeKey('CACHE_DRIVER', 'redis');
        $env_editor->changeKey('SESSION_DRIVER', 'redis');
        $env_editor->changeKey('REDIS_HOST', "{$this->siteName}_redis");
        $env_editor->flush();
    }
}
