<?php


namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class SuperUserAPIService {
    const API_BASE = 'http://127.0.0.1:10000';

    public static function compose_up(string $site_name, string $compose_dir) {
        if(App::environment('local'))
            return true;
        $response = Http::get(self::API_BASE . '/compose_up', [
            'site_name' => $site_name,
            'compose_dir' => $compose_dir
        ]);
        return $response;
    }

    public static function compose_down(string $site_name, string $compose_dir) {
        $response = Http::get(self::API_BASE . '/compose_down', [
            'site_name' => $site_name,
            'compose_dir' => $compose_dir
        ]);
        return $response;
    }

    public static function inspect(string $site_name) {
        $response = Http::get(self::API_BASE . '/inspect', [
            'site_name' => $site_name
        ]);
        $response = json_decode($response);
        if($response->success){
            return json_decode($response->data);
        }
        else{
            return false;
        }
    }

    public static function reload_nginx() {
        $response = Http::get(self::API_BASE . '/reload_nginx');
        return $response;
    }

    public static function remove_site(string $email, string $site_name) {
        $response = Http::get(self::API_BASE . '/remove_site', [
            'email' => $email,
            'site_name' => $site_name
        ]);
        return $response;
    }
}
