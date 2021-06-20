<?php


namespace App\Services;


class ContainerInfoService
{
    protected static  $binary = "/usr/bin/docker";

    public static function getPowerStatus(string $container_name):bool {
        exec(self::$binary.' inspect '.$container_name,$output);
        \Log::debug("inspect output is");
        \Log::debug($output);
        $output = json_decode($output[0]);
        return $output->State->Status == "running";
    }
}
