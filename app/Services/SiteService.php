<?php


namespace App\Services;


use App\Jobs\CreateNewSiteJob;
use App\Models\Site;
use App\Models\User;

class SiteService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function newSite(string $name, string $repo_url): Site
    {
        $port = (new PortService())->getAFreePort();
        $site = Site::create([
            'user_id' => $this->user->id,
            'name' => $name,
            'repo' => $repo_url,
            'port' => $port
        ]);
        CreateNewSiteJob::dispatch($site);
        return $site;
    }
}
