<?php


namespace App\Services;


class GitService
{
    public static function cloneRepo(string $email, string $repo_name, string $url) {
        $repos_dir = config('larahost.repos_dir');
        self::checkForRequiredDirectories($email, $repo_name, $repos_dir);
        exec("git clone $url $repos_dir/$email/$repo_name");
    }

    protected static function checkForRequiredDirectories(string $email, string $repo_name, string $repos_dir) {
        /*
         * check if required directories exist
         */
        if (!is_dir($repos_dir)) {
            mkdir($repos_dir);
        }
        if (!is_dir($repos_dir . '/' . $email)) {
            mkdir($repos_dir . '/' . $email);
        }
        if (!is_dir($repos_dir . '/' . $email . '/' . $repo_name)) {
            mkdir($repos_dir . '/' . $email . '/' . $repo_name);
        }
    }
}
