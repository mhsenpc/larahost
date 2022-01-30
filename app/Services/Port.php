<?php


namespace App\Services;


use App\Exceptions\NoPortsAvailableException;
use App\Models\Site;

class Port {
    protected $reserved_ports = [21, 22, 23, 80, 443, 3306, 8000, 9000, 9001, 10000];

    public function next(): int {
        $starting_port = config('larahost.starting_port.port');
        $busy_ports = $this->getBusyPorts();
        for ($port = $starting_port; $port < $starting_port + 5000; $port++) {
            if (!in_array($port, $busy_ports)) {
                return $port;
            }
        }
        throw new NoPortsAvailableException();
    }

    protected function getBusyPorts(): array {
        $used_ports = Site::query()->withoutGlobalScopes()->whereNotNull('port')->pluck('port')->toArray();
        return array_merge($used_ports, $this->reserved_ports);
    }
}
