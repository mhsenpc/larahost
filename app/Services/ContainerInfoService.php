<?php


namespace App\Services;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ContainerInfoService {
    public static function getPowerStatus(string $container_name): bool {
        if(App::environment('local'))
            return true;
        $info = SuperUserAPIService::inspect($container_name);
        if($info['success']){
            return $info['data']->State->Status == "running";
        }
        else{
            return false;
        }
    }
}
