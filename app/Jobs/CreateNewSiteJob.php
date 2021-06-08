<?php

namespace App\Jobs;

use App\Services\DockerService;
use App\Services\GitService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNewSiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $repo_url;
    /**
     * @var int
     */
    private $port;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $name
     * @param string $repo_url
     * @param int $port
     */
    public function __construct(string $email, string $name, string $repo_url, int $port) {
        $this->email    = $email;
        $this->name     = $name;
        $this->repo_url = $repo_url;
        $this->port     = $port;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $project_dir = GitService::cloneRepo($this->email, $this->name, $this->repo_url);
        (new DockerService())->newLaravelContainer($this->name, $this->port, $project_dir);
    }
}
