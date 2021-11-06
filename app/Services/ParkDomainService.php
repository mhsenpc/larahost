<?php


namespace App\Services;


use App\Models\Site;
use Illuminate\Support\Facades\Log;
use Iodev\Whois\Factory;

class ParkDomainService {
    public static function parkDomain(Site $siteModel, string $domain) {
        $siteModel->domains()->create(
            [
                'name' => $domain,
                'site_id' => $siteModel->id
            ]);

        SuperUserAPIService::bind_domain($domain);
        SuperUserAPIService::reload_dns();
        Log::debug("dns config created for " . $domain);

        $site = new \App\Services\Site($siteModel);
        $site->getDomain()->add($domain);
    }

    public static function isDomainPointedToUs(string $domain) {
        $whois = Factory::get()->createWhois();

        return strpos($whois->lookupDomain($domain)->text, config('larahost.domain.nameserver')) !== false;
    }
}
