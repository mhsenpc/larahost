<?php

namespace App\Http\Controllers;

use App\Models\Deployment;
use App\Models\Site;
use App\Services\PathHelper;

class LogController extends Controller
{
    public function showLog(string $site_name, string $file_name) {
        $site = Site::query()->where('name',$site_name)->firstOrFail();
        $logs_dir = PathHelper::getLaravelLogsDir(\Auth::user()->email, $site->name);
        $log_content             = file_get_contents($logs_dir . '/' . $file_name);
        return view('site.show_laravel_log',compact('log_content','site','file_name'));
    }
}
