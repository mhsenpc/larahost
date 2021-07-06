<?php


namespace App\Services;


class ContainerInfoService {
    public static function getPowerStatus(string $container_name): bool {
        $info = SuperUserAPIService::inspect($container_name);
        if($info){
            return $info[0]->State->Status == "running";
        }
        else{
            return false;
        }
    }
}
