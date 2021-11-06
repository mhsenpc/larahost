<?php


namespace App\Services;


use App\Contracts\DomainInterface;

class Domain implements DomainInterface {
    private ReverseProxy $reverseProxy;
    private int $containerPort;

    public function __construct(int $containerPort) {
        $this->reverseProxy = new ReverseProxy();
        $this->containerPort = $containerPort;
    }

    public function add(string $domain) {
        $this->reverseProxy->generateConfig($domain, $this->containerPort);
        $this->reverseProxy->reload();
    }

    public function remove(string $domain) {
        SuperUserAPIService::remove_domain_config($domain);
        $this->reverseProxy->reload();
    }
}
