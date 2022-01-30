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

    public function createWorker(Request $request, Site $site) {
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

        $siteObj = new \App\Services\Site($site);
        $siteObj->getApplication()->getQueue()->createWorker($site->id, $request->connection, $request->queue, $request->sleep, $request->tries, $request->timeout, $request->num_procs);
        return redirect()->back();
    }

    public function removeWorker(Site $site, int $worker_id) {
        $siteObj = new \App\Services\Site($site);
        $siteObj->getApplication()->getQueue()->removeWorker($site->id, $worker_id);
        return redirect()->back();
    }

    public function restartSupervisor(Request $request, Site $site) {
        $siteObj = new \App\Services\Site($site);
        $siteObj->getContainer()->getSupervisor()->restart();
        return redirect()->back();
    }

    public function restartWorker(Site $site, int $worker_id){
        $siteObj = new \App\Services\Site($site);
        $siteObj->getContainer()->getSupervisor()->restartWorker($worker_id);
        return redirect()->back();
    }

    public function getWorkersStatus(Site $site){
        $siteObj = new \App\Services\Site($site);
        return $siteObj->getContainer()->getSupervisor()->getStatus();
    }

    public function getWorkerLog(Site $site, int $worker_id){
        $siteObj = new \App\Services\Site($site);
        return $siteObj->getApplication()->getQueue()->getWorkerLog($worker_id);
    }
}
