<?php

namespace App\Http\Controllers;

use App\Models\Deployment;
use App\Services\PathHelper;

class LogController extends Controller
{
    public function showLog(string $project_name,string $file_name) {
        $logs_dir = PathHelper::getLaravelLogsDir(\Auth::user()->email, $project_name);
        $log_content             = file_get_contents($logs_dir . '/' . $file_name);
        return view('site.show_laravel_log',compact('log_content'));
    }
}
