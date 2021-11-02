<?php


namespace App\Services;


use App\Models\Site;
use App\Singleton\DeployLogger;
use Illuminate\Support\Facades\Log;
use \CzProject\GitPhp\Git;

class GitService {
    public $source_dir;
    /**
     * @var Site
     */
    private $site;

    protected $deployLogger;

    public function __construct(Site $site) {
        $this->site = $site;
        $this->source_dir = $this->site->getSourceDir();
        $this->deployLogger = DeployLogger::getInstance($this->site);
    }

    public function cloneRepo(): bool {
        $repo_url = $this->getFullRepoUrl();
        $command = "git clone {$repo_url} .";
        $output = SuperUserAPIService::exec($this->site->name, $command);
        $this->deployLogger->addLog($command, $output['data']);
        return $this->isValidRepo();
    }

    /*
     */
    public function pull() {
        if ($this->isValidRepo()) {
            $output = SuperUserAPIService::exec($this->site->name,'git pull');
            $this->deployLogger->addLog("git pull",  $output['data']);
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
        $branches = [];
        try {
            $branches = $repo->getBranches();
        } catch (\Exception $exception) {
            return false;
        }
        return count($branches) > 0;
    }
}
