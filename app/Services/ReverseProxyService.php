<?php


namespace App\Services;


use App\Models\Domain;
use App\Models\Site;
use Illuminate\Support\Facades\Storage;

class ReverseProxyService
{
    protected $conf_d_path= '/etc/nginx/conf.d';

    /**
     * @var Site
     */
    protected $site;

    public function __construct(Site $site) {
        $this->site = $site;
    }

    protected function generateConfig(string $domain) {
        $template = Storage::get('nginx_vhost.template');
        $template = str_replace('$domain', $domain, $template);
        $template = str_replace('$port', $this->site->port, $template);

        SuperUserAPIService::put_contents("{$this->conf_d_path}/{$domain}.conf", $template);
    }

    protected function writeSubdomainConfig(){
        if($this->site->subdomain_status){
            $this->generateConfig("{$this->site->name}.lara-host.ir");
        }
        else{
            $this->removeSubdomainConfig();
        }
    }

    protected function writeParkedDomainsConfig(){
        $domains = Domain::query()->where('site_id',$this->site->id)->get();
        foreach ($domains as $domain){
            $this->generateConfig($domain->name);
        }
    }

    protected function removeSubdomainConfig(){
        SuperUserAPIService::remove_domain_config("{$this->site->name}.lara-host.ir");
    }

    protected function removeParkedDomainsConfig(){
        $domains = Domain::query()->where('site_id',$this->site->id)->get();
        foreach ($domains as $domain){
            SuperUserAPIService::remove_domain_config($domain->name);
        }
    }

    public function reloadNginx() {
        $output = SuperUserAPIService::reload_nginx();
        \Log::debug("nginx reload");
        \Log::debug($output);
    }

    public function writeNginxConfigs(){
        $this->writeSubdomainConfig();
        $this->writeParkedDomainsConfig();
        $this->reloadNginx();
    }

    public function removeNginxConfigs(){
        $this->removeSubdomainConfig();
        $this->removeParkedDomainsConfig();
        $this->reloadNginx();
    }

    public function removeDomainConfig(string $domain){
        $output = SuperUserAPIService::remove_domain_config($domain);
        return $output;
    }

}
