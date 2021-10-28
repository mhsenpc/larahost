<?php


namespace App\Services;


use App\Models\Domain;
use App\Models\Site;

class SiteDestroyerService {
    /**
     * @var Site
     */
    private $site;

    public function __construct(Site $site) {
        $this->site = $site;
    }

    public function destroy() {
        // docker-compose down
        $docker_compose_service = new DockerComposeService($this->site);
        $docker_compose_service->down();

        // remove contents
        $output = SuperUserAPIService::remove_site($this->site->user->email, $this->site);

        // remove nginx config
        $reverse_proxy_service = new ReverseProxyService($this->site);
        $reverse_proxy_service->removeNginxConfigs();

        // remove parked domains
        Domain::query()->where('site_id',$this->site->id)->delete();

        // remove database record
        $this->site->delete();
    }
}
