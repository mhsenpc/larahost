<?php


namespace App\Services;


use App\Jobs\CreateNewSiteJob;
use App\Models\Site;
use App\Models\User;

class NewSiteService {
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function newSite(string $site_name, string $repo_url): Site {
        $site = $this->insertSiteRecord($site_name, $repo_url);
        CreateNewSiteJob::dispatch($site);
        return $site;
    }

    /**
     * @param string $site_name
     * @param string $repo_url
     * @return mixed
     */
    public function insertSiteRecord(string $site_name, string $repo_url) {
        $deploy_commands = implode("\r\n", config('larahost.deploy_commands'));

        $data = [
            'user_id' => $this->user->id,
            'name' => $site_name,
            'repo' => $repo_url,
            'port' => (new PortService())->getAFreePort(),
            'deploy_commands' => $deploy_commands,
            'deploy_token' => TokenCreatorService::generateDeployToken()
        ];
        $site = Site::create($data);
        return $site;
    }
}
