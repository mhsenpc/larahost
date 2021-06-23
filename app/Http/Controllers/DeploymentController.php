<?php

namespace App\Http\Controllers;

use App\Models\Deployment;
use App\Services\PathHelper;

class DeploymentController extends Controller
{
    public function showLog(int $id) {
        $deployment = Deployment::find($id);
        $deployment_logs_dir = PathHelper::getDeploymentLogsDir(\Auth::user()->email, $deployment->site->name);
        echo file_get_contents($deployment_logs_dir .'/'. $deployment->log_file);
    }
}
