<?php

namespace App\Http\Controllers;

use App\Models\Site;

class LogController extends Controller {
    public function showLog(string $site_name, string $file_name) {
        $siteModel = Site::query()->where('name', $site_name)->firstOrFail();
        $site = new \App\Services\Site($siteModel);
        $log_content = file_get_contents($site->getFilesystem()->getLaravelLogsDir() . '/' . $file_name);
        return view('site.show_laravel_log', compact('log_content', 'site', 'file_name'));
    }
}
