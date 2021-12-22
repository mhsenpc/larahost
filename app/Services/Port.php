<?php


namespace App\Services;


use App\Exceptions\NoPortsAvailableException;
use App\Models\Site;
use Config\Larahost;

class Port {
    protected $reserved_ports = [21, 22, 23, 80, 443, 3306, 8000, 9000, 9001, 10000];
    public function next():int {
        $starting_port = config('larahost.starting_port.port');
        $busy_ports = $this->getBusyPorts();
		for ( $starting_port+1; $starting_port < 15000; $starting_port++)
		{
            if (!in_array($starting_port, $busy_ports)) {
                return $starting_port;
            }
		}
        throw new NoPortsAvailableException();
    }

    protected function getBusyPorts(): array {
        $used_ports = Site::query()->withoutGlobalScopes()->whereNotNull('port')->pluck('port')->toArray();
        return array_merge($used_ports, $this->reserved_ports);
    }
}
