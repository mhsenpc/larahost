<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class LaravelDeployCommands extends DeployCommands {
    public function executeOneTimeCommands(): CommandLog {
        $commandLog = new CommandLog($this->siteName);

        Log::debug("first deploy commands");
        $command = 'rm composer.lock';
        $output = SuperUserAPIService::exec($this->siteName, $command);
        Log::debug($output);
        $commandLog->add($command, $output);

        $result = parent::execute();
        $commandLog->addFrom($result);


        $command = 'chown -R www-data:www-data ./';
        $output = SuperUserAPIService::exec($this->siteName, $command);
        Log::debug($output);
        $commandLog->add($command, $output);

        $command = 'php artisan storage:link';
        $output = SuperUserAPIService::exec($this->siteName, $command);
        Log::debug($output);
        $commandLog->add($command, $output);

        $command = 'php artisan key:generate';
        $output = SuperUserAPIService::exec($this->siteName, $command);
        Log::debug($output);
        $commandLog->add($command, $output);

        return $commandLog;
    }
}
