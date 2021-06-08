<?php


namespace App\Services;


use App\Models\Site;
use App\Models\User;

class SiteService
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function newSite(string $name, string $repo_url) {
        Site::create([
            'user_id' => $this->user->id,
            'name' => $name,
            'repo' => $repo_url,
            'port' => (new PortService())->getAFreePort()
        ]);
        GitService::cloneRepo($this->user->email, $name, $repo_url);
    }
}
