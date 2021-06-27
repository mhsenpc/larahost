<?php


namespace App\Services;


class PathHelper
{
    public static function getProjectBasePath(string $email, string $project_name) {
        if (empty(config('larahost.repos_dir')))
            throw new \Exception('Repos dir is not defined');

        return config('larahost.repos_dir') . '/' . $email . '/' . $project_name;

    }

    public static function getDockerComposeDir(string $email, string $project_name) {
        return self::getProjectBasePath($email, $project_name) . '/'.config('larahost.dir_names.docker-compose');
    }

    public static function getSourceDir(string $email, string $project_name) {
        return self::getProjectBasePath($email, $project_name) . '/'.config('larahost.dir_names.source');
    }

    public static function getDeploymentLogsDir(string $email, string $project_name) {
        return self::getProjectBasePath($email, $project_name) . '/'.config('larahost.dir_names.deployment_logs');
    }

    public static function getLaravelLogsDir(string $email, string $project_name) {
        return self::getSourceDir($email, $project_name) . '/'.config('larahost.dir_names.laravel_logs');
    }
}
