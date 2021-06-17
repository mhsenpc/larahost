<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class PostCreationService
{
    protected $binary = "/usr/bin/docker";

    /**
     * @var string
     */
    private $project_name;
    /**
     * @var string
     */
    private $project_dir;

    protected $commands
        = [
            'chown -R www-data:www-data * .*',
            'composer install',
            'php artisan key:generate',
            'php artisan migrate'
        ];

    public function __construct(string $project_name, string $project_dir) {
        $this->project_name = $project_name;
        $this->project_dir  = $project_dir;
    }

    public function runCommands() {
        Log::debug("post run commands");
        foreach ($this->commands as $command) {
            exec("{$this->binary} exec -it {$this->project_name} $command 2>&1", $output);
            Log::debug($output);
        }
    }
}
