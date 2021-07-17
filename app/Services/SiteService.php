<?php


namespace App\Services;


use App\Jobs\CreateNewSiteJob;
use App\Models\Site;
use App\Models\User;

class SiteService {
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function newSite(string $name, string $repo_url, bool $credentials, ?string $git_user, ?string $git_password): Site {
        $deploy_commands = implode("\r\n", config('larahost.deploy_commands'));

        $data = [
            'user_id' => $this->user->id,
            'name' => $name,
            'repo' => $repo_url,
            'port' => (new PortService())->getAFreePort(),
            'deploy_commands' => $deploy_commands
        ];

        if ($credentials) {
            $data['git_user'] = $git_user;
            $data['git_password'] = $git_password;
        }
        $site = Site::create($data);
        CreateNewSiteJob::dispatch($site);
        return $site;
    }
}
