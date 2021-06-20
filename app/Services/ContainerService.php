<?php


namespace App\Services;


class ContainerService
{
    protected static $binary = "/usr/bin/docker";

    public static function start(string $container_name) {
        exec(self::$binary . ' start ' . $container_name);
    }

    public static function stop(string $container_name) {
        exec(self::$binary . ' stop ' . $container_name);
    }

    public static function restart(string $container_name) {
        exec(self::$binary . ' restart ' . $container_name);
    }
}
