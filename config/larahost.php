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
        'workers' => 'workers',
    ],
    'deploy_commands' => [
        'composer install',
        'php artisan migrate --force',
        'php artisan queue:restart',
    ],
    'site_prefix' => env('SITE_PREFIX'),
    'domain' => [
        'nameserver' => 'ns1.lara-host.ir',
        'reserved_sudomains' => [
            'panel',
            'database',
            'redis'
        ]
    ]
];
