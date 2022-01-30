<?php


namespace App\Services;


use App\Contracts\DomainInterface;
use App\Models\Site;
use Illuminate\Support\Facades\Log;
use Iodev\Whois\Factory;

class Domain implements DomainInterface {
    private ReverseProxy $reverseProxy;
    private int $containerPort;
    private Site $siteModel;

    public function __construct(\App\Models\Site $siteModel) {
        $this->reverseProxy = new ReverseProxy();
        $this->containerPort = $siteModel->port;
        $this->siteModel = $siteModel;
    }

    public function add(string $domain) {
        SuperUserAPIService::bind_domain($domain);
        SuperUserAPIService::reload_dns();
        Log::debug("dns config created for " . $domain);

        $this->reverseProxy->generateConfig($domain, $this->containerPort);
        $this->reverseProxy->reload();

        $this->siteModel->domains()->create(
            [
                'name' => $domain,
                'site_id' => $this->siteModel->id
            ]);
    }

    public function remove(string $domain) {
        SuperUserAPIService::remove_domain_config($domain);
        $this->reverseProxy->reload();
    }

    public static function isDomainPointedToUs(string $domain) {
        $whois = Factory::get()->createWhois();

        return strpos($whois->lookupDomain($domain)->text, config('larahost.domain.nameserver')) !== false;
    }
}
