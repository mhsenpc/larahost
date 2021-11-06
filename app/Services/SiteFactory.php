<?php


namespace App\Services;


use App\Events\Site\Creating;
use App\Events\Site\Deploying;
use App\Jobs\CreateNewSiteJob;
use App\Models\Site;
use App\Models\User;
use App\Repositories\SiteRepository;

class SiteFactory {
    private Port $port;
    private TokenGenerator $tokenGenerator;

    public function __construct() {
        $this->port = new Port();
        $this->tokenGenerator = new TokenGenerator();
    }

    /**
     * @param TokenGenerator $tokenGenerator
     */
    public function setTokenGenerator(TokenGenerator $tokenGenerator): void {
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @param Port $port
     */
    public function setPort(Port $port): void {
        $this->port = $port;
    }

    public function getSite(int $userId, string $site_name, string $repo_url, bool $https_credentials, ?string $git_user, ?string $git_password): Site {
        Creating::dispatch($site_name);
        Deploying::dispatch($site_name);
        $siteModel = $this->insertSiteRecord($userId, $site_name, $repo_url, $https_credentials, $git_user, $git_password);
        $site = new Site($siteModel);
        CreateNewSiteJob::dispatch($site);
        return $site;
    }

    /**
     * @param string $site_name
     * @param string $repo_url
     * @return mixed
     */
    protected function insertSiteRecord(int $userId, string $site_name, string $repo_url, bool $https_credentials, ?string $git_user, ?string $git_password): \App\Models\Site {
        $deploy_commands = implode("\r\n", config('larahost.deploy_commands'));

        $data = [
            'user_id' => $userId,
            'name' => $site_name,
            'repo' => $repo_url,
            'port' => $this->port->next(),
            'deploy_commands' => $deploy_commands,
            'deploy_token' => $this->tokenGenerator->generate()
        ];
        if ($https_credentials) {
            $data['git_user'] = $git_user;
            $data['git_password'] = $git_password;
        }
        $siteModel = (new SiteRepository())->insert($data);
        return $siteModel;
    }

    public static function getSiteByDeployToken(string $token) {
        $siteModel = Site::query()->withoutGlobalScopes()->where('deploy_token', $token)->firstOrFail();
        return new \App\Services\Site($siteModel);

    }
}
