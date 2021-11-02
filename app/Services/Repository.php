<?php


namespace App\Services;


use App\Contracts\RepositoryInterface;
use App\Models\Site;
use App\Singleton\DeployLogger;
use CzProject\GitPhp\Git;
use Illuminate\Support\Facades\Log;

class Repository implements RepositoryInterface {

    protected $source_dir;
    /**
     * @var Site
     */
    private $siteModel;

    protected $deployLogger;
    private string $siteName;

    public function __construct(Site $siteModel, string $siteName,string $sourceDir) {
        $this->siteModel = $siteModel;
        $this->source_dir = $sourceDir;
        $this->deployLogger = DeployLogger::getInstance($this->siteModel);
        $this->siteName = $siteName;
    }

    public function cloneRepo(string $repoUrl,string $gitUser,string $gitPass): bool {
        $repo_url = $this->appengAuthToUrl($repoUrl,$gitUser,$gitPass);
        $command = "git clone {$repo_url} .";
        $output = SuperUserAPIService::exec($this->siteName, $command);
        $this->deployLogger->addLog($command, $output['data']);
        return $this->isvalid();
    }

    /*
     */
    public function pull() {
        if ($this->isvalid()) {
            $output = SuperUserAPIService::exec($this->siteName,'git pull');
            $this->deployLogger->addLog("git pull",  $output['data']);
            return true;
        } else {
            return false;
        }
    }

    protected function appengAuthToUrl(string $repo, string $user, string $pass): string {
        if (!empty($user)) {
            $result = $repo;
            $result = str_replace('https://www.', '', $result);
            $result = str_replace('https://', '', $result);
            $result = "https://{$user}:{$pass}@$result";
            Log::debug($result);
            return $result;
        } else {
            return $repo;
        }
    }

    public function isvalid(): bool {
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
