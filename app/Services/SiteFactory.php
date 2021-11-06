<?php


namespace App\Services;


use App\Events\Site\Creating;
use App\Events\Site\Deploying;
use App\Jobs\CreateNewSiteJob;
use App\Models\User;
use App\Repositories\SiteRepository;

class SiteFactory {
    private $user;
    private PortService $portService;
    private TokenGenerator $tokenGenerator;

    public function __construct(User $user) {
        $this->user = $user;
        $this->portService = new PortService();
    }

    /**
     * @param TokenGenerator $tokenGenerator
     */
    public function setTokenGenerator(TokenGenerator $tokenGenerator): void {
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @param PortService $portService
     */
    public function setPortService(PortService $portService): void {
        $this->portService = $portService;
    }

    public function getSite(string $site_name, string $repo_url, bool $https_credentials, ?string $git_user, ?string $git_password): Site {
        Creating::dispatch($site_name);
        Deploying::dispatch($site_name);
        $siteModel = $this->insertSiteRecord($site_name, $repo_url, $https_credentials, $git_user, $git_password);
        $site = new Site($siteModel);
        CreateNewSiteJob::dispatch($site);
        return $site;
    }

    /**
     * @param string $site_name
     * @param string $repo_url
     * @return mixed
     */
    protected function insertSiteRecord(string $site_name, string $repo_url, bool $https_credentials, ?string $git_user, ?string $git_password):\App\Models\Site {
        $deploy_commands = implode("\r\n", config('larahost.deploy_commands'));

        $data = [
            'user_id' => $this->user->id,
            'name' => $site_name,
            'repo' => $repo_url,
            'port' => $this->portService->getAFreePort(),
            'deploy_commands' => $deploy_commands,
            'deploy_token' => $this->tokenGenerator->generate()
        ];
        if ($https_credentials) {
            $data['git_user'] = $git_user;
            $data['git_password'] = $git_password;
        }
        $siteModel =(new SiteRepository())->insert($data);
        return $siteModel;
    }
}
