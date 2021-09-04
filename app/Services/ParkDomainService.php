<?php


namespace App\Services;


use App\Models\Site;
use Illuminate\Support\Facades\Log;
use Iodev\Whois\Factory;

class ParkDomainService {
    public static function parkDomain(Site $site, string $domain) {
        $site->domains()->create(
            [
                'name' => $domain,
                'site_id' => $site->id
            ]);

        SuperUserAPIService::bind_domain($domain);
        SuperUserAPIService::reload_dns();
        Log::debug("dns config created for " . $domain);

        $reverse_proxy_service = new ReverseProxyService($site);
        $reverse_proxy_service->writeNginxConfigs();
    }

    public static function isDomainPointedToUs(string $domain) {
        $whois = Factory::get()->createWhois();

        return strpos($whois->lookupDomain($domain)->text, 'ns1.lara-host.ir') !== false;
    }
}
