<?php
return [
    'repos_dir' => env('REPOS_DIR','/home/repos'),
    'dir_names' => [
        'docker-compose' => 'docker-compose',
        'source' => 'source',
        'deployment_logs' => 'deployment_logs',
        'laravel_logs' => 'storage/logs',
        'super_user_api_url' => 'http://127.0.0.1:10000'
    ],
    'deploy_commands' => [
        'chown -R www-data:www-data ./',
        'composer install',
        'php artisan key:generate',
        'php artisan migrate'
    ],
];
