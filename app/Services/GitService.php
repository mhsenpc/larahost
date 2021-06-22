<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class GitService
{
    public $source_dir;
    public $project_base_dir;

    public function cloneRepo(string $email, string $repo_name, string $url) {
        $this->createSourceDirForProject($email, $repo_name);
        exec("git clone $url {$this->source_dir}");
        Log::debug('git clone');
        Log::debug("git clone $url {$this->source_dir}");
    }

    protected function createSourceDirForProject(string $email, string $project_name) {
        $repos_dir = config('larahost.repos_dir');
        /*
         * check if required directories exist
         */
        if (!is_dir($repos_dir)) {
            mkdir($repos_dir);
        }
        if (!is_dir($repos_dir . '/' . $email)) {
            mkdir($repos_dir . '/' . $email);
        }

        $this->project_base_dir = $repos_dir . '/' . $email . '/' . $project_name;
        if (!is_dir($this->project_base_dir)) {
            mkdir($this->project_base_dir);
        }

        $this->source_dir = $repos_dir . '/' . $email . '/' . $project_name . '/source';
        if (!is_dir($this->source_dir)) {
            mkdir($this->source_dir);
        }
    }
}
