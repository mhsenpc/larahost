<?php


namespace App\Services;


class PathHelper
{
    public static function getProjectBasePath(string $email, string $project_name) {
        if (empty(config('larahost.repos_dir')))
            throw new \Exception('Repos dir is not defined');

        return config('larahost.repos_dir') . '/' . $email . '/' . $project_name;

    }

    public static function getDockerComposePath(string $email, string $project_name) {
        return self::getProjectBasePath($email, $project_name) . '/docker-compose';
    }

    public static function getSourceFolderPath(string $email, string $project_name) {
        return self::getProjectBasePath($email, $project_name) . '/source';
    }
}
