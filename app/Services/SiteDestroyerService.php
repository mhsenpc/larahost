<?php


namespace App\Services;


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
        $project_dir = PathHelper::getProjectBasePath($this->site->user->email, $this->site->name);
        $docker_compose_service = new DockerComposeService();
        $docker_compose_service->stop($this->site->name, $project_dir);

        // remove nginx config
        $reverse_proxy_service = new ReverseProxyService($this->site->name);
        $reverse_proxy_service->removeSiteConfig($this->site->user->email);

        // reload nginx
        $reverse_proxy_service->reloadNginx();

        // remove sites table record
        exec("rm -rf $project_dir");

        // remove database record
        $this->site->delete();
    }
}
