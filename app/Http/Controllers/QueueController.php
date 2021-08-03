<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Worker;
use App\Services\PathHelper;
use App\Services\QueueService;
use App\Services\SuperUserAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $queue_service = new QueueService($site);
        $queue_service->createWorker($request->connection, $request->queue, $request->sleep, $request->tries, $request->timeout, $request->num_procs);
        return redirect()->back();
    }

    public function removeWorker(Site $site,int $worker_id) {
        $queue_service = new QueueService($site);
        $queue_service->removeWorker($worker_id);
        return redirect()->back();
    }

    public function restartSupervisor(Request $request, Site $site) {
        $queue_service = new QueueService($site);
        $queue_service->restartSupervisor();
        return redirect()->back();
    }

    public function restartWorker(Site $site,int $worker_id){
        $queue_service = new QueueService($site);
        $queue_service->restartWorker($worker_id);
        return redirect()->back();
    }

    public function getWorkersStatus(Site $site){
        $queue_service = new QueueService($site);
        return $queue_service->getWorkersStatus();
    }

    public function getWorkerLog(Site $site,int $worker_id){
        $queue_service = new QueueService($site);
        return $queue_service->getWorkerLog($worker_id);
    }
}
