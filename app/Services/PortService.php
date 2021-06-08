<?php


namespace App\Services;


use App\Models\Site;

class PortService
{
    protected $reserved_ports = [8000, 9000, 9001];
    protected $busy_ports = [];

    public function __construct() {
        $used_ports       = Site::query()->whereNotNull('port')->pluck('port')->toArray();
        $this->busy_ports = array_merge($used_ports, $this->reserved_ports);
        dd($this->busy_ports);
    }

    protected function isReserved($port) {
        return in_array($port,$this->busy_ports);
    }

    public function getAFreePort() {
        while ($this->isReserved($port = random_int(10000,15000)));
        return $port;
    }
}
