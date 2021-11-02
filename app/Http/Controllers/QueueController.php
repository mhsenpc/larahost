<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Worker;
use Illuminate\Http\Request;


class QueueController extends Controller {
    public function index(Request $request, Site $site) {
        $workers = Worker::query()->where('site_id', $site->id)->get();
        return view('site.workers', compact('workers','site'));
    }

    public function createWorker(Request $request, Site $siteModel) {
        $request->validate([
            'timeout' => 'nullable|numeric',
            'sleep' => 'nullable|numeric',
            'num_procs' => 'nullable|numeric',
            'tries' => 'nullable|numeric',
        ]);

        if(empty($request->connection)){
            $request->connection = "redis";
        }

        if(empty($request->queue)){
            $request->queue = "default";
        }

        if(empty($request->sleep)){
            $request->sleep = 10;
        }

        if(empty($request->timeout)){
            $request->timeout = 60;
        }

        if(empty($request->num_procs)){
            $request->num_procs = 1;
        }

        if(empty($request->tries)){
            $request->tries = 1;
        }

        $site = new \App\Services\Site($siteModel);
        $site->getApplication()->getQueue()->createWorker($siteModel->id, $request->connection, $request->queue, $request->sleep, $request->tries, $request->timeout, $request->num_procs);
        return redirect()->back();
    }

    public function removeWorker(Site $siteModel, int $worker_id) {
        $site = new \App\Services\Site($siteModel);
        $site->getApplication()->getQueue()->removeWorker($siteModel->id, $worker_id);
        return redirect()->back();
    }

    public function restartSupervisor(Request $request, Site $siteModel) {
        $site = new \App\Services\Site($siteModel);
        $site->getContainer()->getSupervisor()->restart();
        return redirect()->back();
    }

    public function restartWorker(Site $siteModel, int $worker_id){
        $site = new \App\Services\Site($siteModel);
        $site->getContainer()->getSupervisor()->restartWorker($worker_id);
        return redirect()->back();
    }

    public function getWorkersStatus(Site $siteModel){
        $site = new \App\Services\Site($siteModel);
        return $site->getContainer()->getSupervisor()->getStatus();
    }

    public function getWorkerLog(Site $siteModel,int $worker_id){
        $site = new \App\Services\Site($siteModel);
        return $site->getApplication()->getQueue()->getWorkerLog($worker_id);
    }
}
