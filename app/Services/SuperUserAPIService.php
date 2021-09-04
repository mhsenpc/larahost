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
        return $response->json();
    }

    public static function compose_down(string $site_name, string $compose_dir) {
        $response = Http::get(config('larahost.super_user_api_url') . '/compose_down', [
            'site_name' => $site_name,
            'compose_dir' => $compose_dir
        ]);
        return $response->json();
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

    public static function exec_command(string $site_name, string $command):array {
        if(App::environment('local')){
            return ['success'=>true,'data'=>".gitignore \n app"];
        }
        $response = Http::get(config('larahost.super_user_api_url') . '/exec', [
            'site_name' => $site_name,
            'command' => $command
        ]);
        return $response->json();
    }

    public static function reload_nginx() {
        $response = Http::get(config('larahost.super_user_api_url') . '/reload_nginx');
        return $response->json();
    }

    public static function remove_site(string $email, string $site_name) {
        $response = Http::get(config('larahost.super_user_api_url') . '/remove_site', [
            'email' => $email,
            'site_name' => $site_name
        ]);
        return $response->json();
    }

    public static function remove_domain_config(string $domain) {
        $response = Http::get(config('larahost.super_user_api_url') . '/remove_domain_config', [
            'domain' => $domain,
        ]);
        return $response->json();
    }
    public static function remove_dir(string $dir) {
        $response = Http::get(config('larahost.super_user_api_url') . '/remove_dir', [
            'dir' => $dir,
        ]);
        return $response->json();
    }

    public static function generate_key_pair(string $email,string $output_dir) {
        $response = Http::get(config('larahost.super_user_api_url') . '/generate_key_pair', [
            'email' => $email,
            'output_dir' => $output_dir,
        ]);
        return $response->json();
    }

    public static function restart_container(string $container_name) {
        $response = Http::get(config('larahost.super_user_api_url') . '/restart_container', [
            'container_name' => $container_name
        ]);
        return $response->json();
    }

    public static function new_file(string $file_name,string $content) {
        $response = Http::get(config('larahost.super_user_api_url') . '/new_file', [
            'file_name' => $file_name,
            'content' => $content,
        ]);
        return $response->json();
    }

    public static function bind_domain(string $domain) {
        $response = Http::get(config('larahost.super_user_api_url') . '/bind_domain', [
            'domain' => $domain,
        ]);
        return $response->json();
    }

    public static function reload_dns() {
        $response = Http::get(config('larahost.super_user_api_url') . '/reload_dns');
        return $response->json();
    }
}
