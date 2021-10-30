<?php


namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class SuperUserAPIService {
    protected static function sendApiRequest($functionName, $arguments = []) {
        if (App::environment('local'))
            return true;
        $response = Http::get(config('larahost.super_user_api_url') . '/' . $functionName, $arguments);
        return $response->json();
    }

    public static function new_folder(string $path) {
        return self::sendApiRequest(__FUNCTION__, compact('path'));
    }

    public static function compose_up(string $site_name, string $compose_dir) {
        return self::sendApiRequest(__FUNCTION__, compact('site_name', 'compose_dir'));
    }

    public static function compose_down(string $site_name, string $compose_dir) {
        return self::sendApiRequest(__FUNCTION__, compact('site_name', 'compose_dir'));
    }

    public static function inspect(string $site_name) {
        return self::sendApiRequest(__FUNCTION__, compact('site_name'));
    }

    public static function exec(string $site_name, string $command): array {
        return self::sendApiRequest(__FUNCTION__, compact('site_name', 'command'));
    }

    public static function reload_nginx() {
        return self::sendApiRequest(__FUNCTION__);
    }

    public static function remove_domain_config(string $domain) {
        return self::sendApiRequest(__FUNCTION__,compact('domain'));
    }

    public static function remove_dir(string $dir) {
        return self::sendApiRequest(__FUNCTION__,compact('dir'));
    }

    public static function generate_key_pair(string $email, string $output_dir) {
        return self::sendApiRequest(__FUNCTION__,compact('email','output_dir'));
    }

    public static function restart_container(string $container_name) {
        return self::sendApiRequest(__FUNCTION__,compact('container_name'));
    }

    public static function new_file(string $file_name, string $content) {
        return self::sendApiRequest(__FUNCTION__,compact('file_name','content'));
    }

    public static function bind_domain(string $domain) {
        return self::sendApiRequest(__FUNCTION__,compact('domain'));
    }

    public static function reload_dns() {
        return self::sendApiRequest(__FUNCTION__);
    }
}
