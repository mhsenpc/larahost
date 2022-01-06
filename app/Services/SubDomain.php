<?php


namespace App\Services;


use App\Contracts\DomainInterface;

class SubDomain implements DomainInterface {
    private ReverseProxy $reverseProxy;
    private int $containerPort;

    public function __construct(int $containerPort) {
        $this->reverseProxy = new ReverseProxy();
        $this->containerPort = $containerPort;
    }

    public function add(string $subdomain):bool {
        $subdomain .= config('larahost.sudomain');
        $this->reverseProxy->generateConfig($subdomain, $this->containerPort);
        $this->reverseProxy->reload();
        return true;
    }

    public function remove(string $subdomain) {
        SuperUserAPIService::remove_domain_config($subdomain);
        $this->reverseProxy->reload();
    }
}
