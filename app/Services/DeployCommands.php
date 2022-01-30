<?php


namespace App\Services;

class DeployCommands {
    protected string $siteName;
    private string $deployCommands;

    public function __construct(string $siteName, string $deployCommands) {
        $this->siteName = $siteName;
        $this->deployCommands = $deployCommands;
    }

    public function execute(): CommandLog {
        $commands = preg_split("/\r\n|\n|\r/", $this->deployCommands);
        $commandLog = new CommandLog($this->siteName);
        foreach ($commands as $command) {
            $output = SuperUserAPIService::exec($this->siteName, $command);
            $commandLog->add($command, $output);
        }

        return $commandLog;
    }

}
