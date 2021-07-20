<?php

namespace App\Http\Controllers;

use App\Models\Deployment;
use App\Services\PathHelper;
use Illuminate\Support\Facades\Auth;

class DeploymentController extends Controller
{
    public function showLog(int $deployment_id) {
        $deployment = Deployment::findOrFail($deployment_id);
        if(! $deployment->site){
            abort(403);
        }
        $site = $deployment->site;
        $deployment_logs_dir = PathHelper::getDeploymentLogsDir(Auth::user()->email, $deployment->site->name);
        $log_content = file_get_contents($deployment_logs_dir .'/'. $deployment->log_file);
        return view('site.show_deployment_log',compact('log_content','site'));
    }

    public function lastDeploymentLog(int $site_id){
        $deployment = Deployment::query()->where('site_id',$site_id)->orderBy('created_at','desc')->first();
        if(empty($deployment)){
            return response('تاکنون برای این سایت هیچ deployment ای انجام نشده است');
        }
        $deployment_logs_dir = PathHelper::getDeploymentLogsDir(Auth::user()->email, $deployment->site->name);
        $log_content = file_get_contents($deployment_logs_dir .'/'. $deployment->log_file);
        return response($log_content);
    }
}
