<?php

namespace App\Http\Controllers;

use App\Models\Site;

class LogController extends Controller {
    public function showLog(string $site_name, string $file_name) {
        $site = Site::query()->where('name', $site_name)->firstOrFail();
        $siteObj = new \App\Services\Site($site);
        $log_content = file_get_contents($siteObj->getFilesystem()->getLaravelLogsDir() . '/' . $file_name);
        return view('site.show_laravel_log', compact('log_content', 'site', 'file_name'));
    }
}
