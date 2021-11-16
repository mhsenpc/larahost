<?php

namespace App\Http\Controllers;

use App\Models\Deployment;
use App\Models\Site;
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
        $siteObj = new \App\Services\Site($site);
        $log_content = file_get_contents($siteObj->getFilesystem()->getDeploymentLogsDir() .'/'. $deployment->log_file);
        return view('site.show_deployment_log',compact('log_content','site','deployment'));
    }

    public function lastDeploymentLog(int $site_id){
        $deployment = Deployment::query()->where('site_id',$site_id)->orderBy('created_at','desc')->first();
        if(empty($deployment)){
            return response('تاکنون برای این سایت هیچ deployment ای انجام نشده است');
        }
        $siteObj = new \App\Services\Site($deployment->site);
        $log_content = file_get_contents($siteObj->getFilesystem()->getDeploymentLogsDir() .'/'. $deployment->log_file);
        return view('site.last_deployment_log',compact('log_content'));
    }
}
