<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class GitService
{
    public $source_dir;
    public $project_base_dir;

    public function cloneRepo(string $email, string $site_name, string $url)
    {
        $this->createSourceDirForProject($email, $site_name);
        exec("git clone $url {$this->source_dir}");
    }

    /*
     */
    public function pull(string $email, string $site_name)
    {
        $this->createSourceDirForProject($email, $site_name);
        $files = scandir(PathHelper::getSourceDir($email, $site_name));
        $files = array_diff($files, array('..', '.')); //remove invalid files
        if (count($files) == 0) {
            throw new \Exception("Source dir is empty!");
        }
        exec("cd {$this->source_dir};git pull");
    }

    protected function createSourceDirForProject(string $email, string $project_name)
    {
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
