<?php


namespace App\Services;


class PathHelper {
    public static function getProjectBaseDir(string $email, string $site_name) {
        if (empty(config('larahost.repos_dir')))
            throw new \Exception('Repos dir is not defined');

        return config('larahost.repos_dir') . '/' . $email . '/' . $site_name;
    }

    public static function getDockerComposeDir(string $email, string $site_name) {
        return self::getProjectBaseDir($email, $site_name) . '/' . config('larahost.dir_names.docker-compose');
    }

    public static function getSourceDir(string $email, string $site_name) {
        return self::getProjectBaseDir($email, $site_name) . '/' . config('larahost.dir_names.source');
    }

    public static function getDeploymentLogsDir(string $email, string $site_name) {
        return self::getProjectBaseDir($email, $site_name) . '/' . config('larahost.dir_names.deployment_logs');
    }

    public static function getLaravelLogsDir(string $email, string $site_name) {
        return self::getSourceDir($email, $site_name) . '/' . config('larahost.dir_names.laravel_logs');
    }

    public static function getSSHKeysDir(string $email): string {
        if(!is_dir(config('larahost.keys_dir'))){
            mkdir(config('larahost.keys_dir'));
        }
        $user_keys = config('larahost.keys_dir') . '/' . $email;
        if(!is_dir($user_keys)){
            mkdir($user_keys);
        }
        return $user_keys;
    }
}
