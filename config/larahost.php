<?php
return [
    'repos_dir' => env('REPOS_DIR', '/home/repos'),
    'keys_dir' => env('KEYS_DIR', '/home/keys'),
    'super_user_api_url' => 'http://127.0.0.1:10000',
    'dir_names' => [
        'docker-compose' => 'docker-compose',
        'source' => 'source',
        'deployment_logs' => 'deployment_logs',
        'laravel_logs' => 'storage/logs',
        'db' => 'db',
    ],
    'deploy_commands' => [
        'composer install',
        'php artisan migrate --force',
        'php artisan queue:restart',
    ],
];
