<?php

namespace App\Http\Controllers;

use App\Models\Deployment;
use App\Services\PathHelper;
use Illuminate\Support\Facades\Auth;

class DeploymentController extends Controller
{
    public function showLog(int $id) {
        $deployment = Deployment::findOrFail($id);
        if(! $deployment->site){
            abort(403);
        }
        $site = $deployment->site;
        $deployment_logs_dir = PathHelper::getDeploymentLogsDir(Auth::user()->email, $deployment->site->name);
        $log_content = file_get_contents($deployment_logs_dir .'/'. $deployment->log_file);
        return view('site.show_deployment_log',compact('log_content','site'));
    }
}
