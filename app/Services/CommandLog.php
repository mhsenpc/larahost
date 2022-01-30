<?php


namespace App\Services;


class CommandLog {
    protected $logs = [];
    private string $siteName;

    public function __construct(string $siteName) {
        $this->siteName = $siteName;
    }

    /**
     * @return array
     */
    public function getLogs(): array {
        return $this->logs;
    }

    public function add(string $command, $output) {
        if(is_array($output)){
            $output = implode("\r\n",$output);
        }
        $this->logs[$command] = $output;
    }

    public function getFormattedLog():string {
        $result = "";
        foreach ($this->logs as $command => $output) {
            $result .= "root@" . $this->siteName . ":/var/www/html# " . $command . "\r\n";
            $result .= $output . "\r\n";
        }
        return $result;
    }

    public function addFrom(CommandLog $commandLog) {
        foreach ($commandLog->getLogs() as $command => $output) {
            $this->add($command, $output);
        }
    }
// I guess we need some function to clear log output
//    protected static function clearReposPathFromOutput($output) {
//        if (is_array($output)) {
//            $output = implode('\r\n', $output);
//        }
//
//        $repos_dir = config('larahost.repos_dir');
//        $output = str_replace("{$repos_dir}/{self::$site->user->email}/{self::$site->name}/source", '/var/www/html', $output);
//        return $output;
//    }
}
