<?php


namespace App\Services;


class ContainerInfoService {
    protected static $binary = "/usr/bin/docker";

    public static function getPowerStatus(string $container_name): bool {
        exec(self::$binary . ' inspect ' . $container_name, $output);
        $output = implode('', $output);
        $output = json_decode($output);
        if (empty($output)) {
            return false;
        }
        \Log::debug($output);
        return $output[0]->State->Status == "running";
    }
}
