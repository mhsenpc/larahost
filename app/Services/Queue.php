<?php


namespace App\Services;


use App\Models\Worker;
use Illuminate\Support\Facades\Storage;

class Queue {
    /**
     * @var \App\Models\Site
     */
    private string $siteName;
    private string $workersDir;
    private Supervisor $supervisor;

    public function __construct(string $siteName, string $workersDir, \App\Services\Supervisor $supervisor) {
        $this->siteName = $siteName;
        $this->workersDir = $workersDir;
        $this->supervisor = $supervisor;
    }

    public function createWorker(int $siteId, string $connection, string $queue, int $sleep, int $tries, int $timeout, int $num_procs) {
        // insert record in db
        $worker = Worker::query()->create([
            'connection' => $connection,
            'queue' => $queue,
            'sleep' => $sleep,
            'tries' => $tries,
            'timeout' => $timeout,
            'num_procs' => $num_procs,
            'site_id' => $siteId
        ]);

        // create config for new worker
        $template = Storage::get('supervisor.conf.template');
        $template = str_replace('$connection', $connection, $template);
        $template = str_replace('$queue', $queue, $template);
        $template = str_replace('$sleep', $sleep, $template);
        $template = str_replace('$tries', $tries, $template);
        $template = str_replace('$timeout', $timeout, $template);
        $template = str_replace('$num_procs', $num_procs, $template);
        $template = str_replace('$id', $worker->id, $template);
        SuperUserAPIService::put_contents($this->workersDir . "/laravel-worker-{$worker->id}.conf", $template);
        $this->supervisor->reload();

    }

    public function removeWorker(int $siteId, int $worker_id) {
        $worker = Worker::query()->where('site_id', $siteId)->findOrFail($worker_id);

        // remove config of worker
        SuperUserAPIService::remove_dir($this->workersDir . "/laravel-worker-{$worker->id}.conf");

        // remove record from db
        $worker->delete();

        // reload supervisor
        $this->supervisor->reload();
    }

    public function getWorkerLog(int $id) {
        $result = SuperUserAPIService::exec($this->siteName, "cat /var/log/worker-$id.log");
        if($result['data'])
            return $result['data'];
        else
            return "No contents yet";
    }
}
