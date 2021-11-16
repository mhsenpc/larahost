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
        $repo_url = $this->getFullRepoUrl();
        $command = "git clone {$repo_url} .";
        $output = SuperUserAPIService::exec_command($this->site->name, $command);
        sleep(40);
        $this->deploy_log_service->addLog($command, $output['data']);
        return $this->isValidRepo();
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

    protected function getFullRepoUrl(): string {
        if (!empty($this->site->git_user)) {
            $result = $this->site->repo;
            $result = str_replace('https://www.', '', $result);
            $result = str_replace('https://', '', $result);
            $result = "https://{$this->site->git_user}:{$this->site->git_password}@$result";
            Log::debug($result);
            return $result;
        } else {
            return $this->site->repo;
        }
    }

    protected function isValidRepo(): bool {
        $git = new Git;
        $repo = $git->open($this->source_dir);
        Log::debug('check for source dir');
        Log::debug($this->source_dir);

        try {
            $branch_name = $repo->getCurrentBranchName();
            Log::debug("branch name is $branch_name");
            return true;
        } catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }
}
