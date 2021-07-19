<?php


namespace App\Services;


use Illuminate\Support\Facades\App;

class ContainerInfoService {
    public static function getPowerStatus(string $container_name): bool {
        if(App::environment('local'))
            return true;
        $info = SuperUserAPIService::inspect($container_name);
        if($info){
            return $info[0]->State->Status == "running";
        }
        else{
            return false;
        }
    }
}
