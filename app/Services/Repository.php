<?php


namespace App\Services;


use App\Contracts\RepositoryInterface;
use CzProject\GitPhp\Git;
use Exception;
use Illuminate\Support\Facades\Log;

class Repository implements RepositoryInterface {

    protected $source_dir;
    protected $deployLogger;
    protected string $siteName;

    public function __construct(string $siteName, string $sourceDir) {
        $this->source_dir = $sourceDir;
        $this->siteName = $siteName;
    }

    public function cloneRepo(string $repoUrl, ?string $gitUser, ?string $gitPass): array {
        $repo_url = $this->appengAuthToUrl($repoUrl, $gitUser, $gitPass);
        $command = "git clone {$repo_url} .";
        $output = SuperUserAPIService::exec($this->siteName, $command);
        $commandLog = new CommandLog($this->siteName);

        $commandLog->add($command, $output['data']);
        return [
            'success' => $this->isvalid(),
            'logs' => $commandLog
        ];
    }

    /*
     */
    public function pull() {
        $commandLog = new CommandLog($this->siteName);
        if ($this->isvalid()) {
            $output = SuperUserAPIService::exec($this->siteName, 'git pull');
            $commandLog->add('git pull', $output['data']);
            return ['success' => true, 'logs' => $output['data']];
        } else {
            return ['success' => false];
        }

    }

    protected function appengAuthToUrl(string $repo, ?string $user, ?string $pass): string {
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
        } catch (Exception $exception) {
            return false;
        }
        return !empty($repo->getCurrentBranchName());
    }
}
