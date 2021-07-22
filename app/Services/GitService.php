<?php


namespace App\Services;


use App\Models\Site;
use Illuminate\Support\Facades\Log;
use \CzProject\GitPhp\Git;

class GitService {
    public $source_dir;
    public $project_base_dir;
    /**
     * @var Site
     */
    private $site;

    public function __construct(Site $site) {
        $this->site = $site;
        $this->source_dir = PathHelper::getSourceDir($site->user->email, $site->name);
        $this->project_base_dir = PathHelper::getProjectBaseDir($site->user->email, $site->name);
    }

    public function cloneRepo(): bool {
        $this->createSourceDirForProject($this->site->user->email);
        $repo_url = $this->getFullRepoUrl($this->site);
        exec("git clone {$repo_url} {$this->source_dir}");

        return $this->isValidRepo();
    }

    protected function getFullRepoUrl(Site $site): string {
        if (!empty($site->git_user)) {
            $result = $site->repo;
            $result = str_replace('https://www.', '', $result);
            $result = str_replace('https://', '', $result);
            $result = "https://{$site->git_user}:{$site->git_password}@$result";
            Log::debug($result);
            return $result;
        } else {
            return $site->repo;
        }
    }

    /*
     */
    public function pull() {
        if ($this->isValidRepo()) {
            exec("cd {$this->source_dir};git pull");
            return true;
        } else {
            return false;
        }
    }

    protected function createSourceDirForProject(string $email) {
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

        if (!is_dir($this->project_base_dir)) {
            mkdir($this->project_base_dir);
        }

        // if this directory already exists. it might be because of uninstall repository
        if (is_dir($this->source_dir)) {
            SuperUserAPIService::remove_dir($this->source_dir);
        }

        mkdir($this->source_dir);
    }

    protected function isValidRepo(): bool {
        $git = new Git;
        $repo = $git->open($this->source_dir);
        $branches = [];
        try {
            $branches = $repo->getBranches();
        } catch (\Exception $exception) {
            return false;
        }
        return count($branches) > 0;
    }
}
