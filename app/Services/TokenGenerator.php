<?php


namespace App\Services;


use Illuminate\Support\Str;

class TokenGenerator {
    public function generate(){
        return Str::random(40);
    }
}
