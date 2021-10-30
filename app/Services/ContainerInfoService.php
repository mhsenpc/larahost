<?php


namespace App\Services;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ContainerInfoService {
    public static function getPowerStatus(string $container_name): bool {
        if(App::environment('local'))
            return true;
        $info = SuperUserAPIService::inspect($container_name);
        Log::debug('inspect is');
        Log::debug(var_export($info,true));
        if($info['success']){
            return $info['data'][0]->State->Status == "running";
        }
        else{
            return false;
        }
    }
}
