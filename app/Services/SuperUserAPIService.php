<?php


namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class SuperUserAPIService {

    public static function compose_up(string $site_name, string $compose_dir) {
        if (App::environment('local'))
            return true;
        $response = Http::get(config('larahost.super_user_api_url') . '/compose_up', [
            'site_name' => $site_name,
            'compose_dir' => $compose_dir
        ]);
        return $response;
    }

    public static function compose_down(string $site_name, string $compose_dir) {
        $response = Http::get(config('larahost.super_user_api_url') . '/compose_down', [
            'site_name' => $site_name,
            'compose_dir' => $compose_dir
        ]);
        return $response;
    }

    public static function inspect(string $site_name) {
        $response = Http::get(config('larahost.super_user_api_url') . '/inspect', [
            'site_name' => $site_name
        ]);
        $response = json_decode($response);
        if ($response->success) {
            return json_decode($response->data);
        } else {
            return false;
        }
    }

    public static function exec_command(string $site_name, string $command) {
        if(App::environment('local')){
            return json_encode(['success'=>true,'data'=>".gitignore \n app"]);
        }
        $response = Http::get(config('larahost.super_user_api_url') . '/exec', [
            'site_name' => $site_name,
            'command' => $command
        ]);
        return $response;
    }

    public static function reload_nginx() {
        $response = Http::get(config('larahost.super_user_api_url') . '/reload_nginx');
        return $response;
    }

    public static function remove_site(string $email, string $site_name) {
        $response = Http::get(config('larahost.super_user_api_url') . '/remove_site', [
            'email' => $email,
            'site_name' => $site_name
        ]);
        return $response;
    }

    public static function remove_dir(string $dir) {
        $response = Http::get(config('larahost.super_user_api_url') . '/remove_dir', [
            'dir' => $dir,
        ]);
        return $response;
    }

    public static function generate_key_pair(string $email,string $output_dir) {
        $response = Http::get(config('larahost.super_user_api_url') . '/generate_key_pair', [
            'email' => $email,
            'output_dir' => $output_dir,
        ]);
        return $response;
    }
}
