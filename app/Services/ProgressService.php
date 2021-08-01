<?php


namespace App\Services;


use Illuminate\Support\Facades\Cache;

class ProgressService {
    public static function start(string $process_name) {
        Cache::put($process_name, 1, 60 * 15);
    }

    public static function finish(string $process_name) {
        Cache::forget($process_name);
    }

    public static function isActive(string $process_name): bool {
        return Cache::has($process_name);
    }
}
