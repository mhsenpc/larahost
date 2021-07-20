<?php


namespace App\Services;


use Illuminate\Support\Str;

class TokenCreatorService {
    public static function generateDeployToken(){
        return Str::random(40);
    }
}
