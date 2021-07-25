<?php


namespace App\Services;


use App\Models\Site;
use Illuminate\Support\Facades\Log;
use \CzProject\GitPhp\Git;

class GitService {
    public $source_dir;
    /**
     * @var Site
     */
    private $site;
    /**
     * @var DeployLogService
     */
    protected $deploy_log_service;

    public function __construct(Site $site, DeployLogService $deploy_log_service) {
        $this->site = $site;
        $this->source_dir = PathHelper::getSourceDir($site->user->email, $site->name);
        $this->deploy_log_service = $deploy_log_service;
    }

    public function cloneRepo(): bool {
        $repo_url = $this->getFullRepoUrl($this->site);
        exec("git clone {$repo_url} {$this->source_dir}", $output);
        $output = SuperUserAPIService::exec_command($this->site->name, "git clone {$repo_url} .");
        $this->deploy_log_service->addLog("git clone " . $this->site->repo . " .", $output['data']);
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
            $output = SuperUserAPIService::exec_command($this->site->name,'git pull');
            $this->deploy_log_service->addLog("git pull",  $output['data']);
            return true;
        } else {
            return false;
        }
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
