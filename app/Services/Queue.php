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

    public function __construct(string $siteName, string $workersDir) {
        $this->siteName = $siteName;
        $this->workersDir = $workersDir;
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
        $this->reloadSupervisor();

    }

    public function removeWorker(int $siteId, int $worker_id) {
        $worker = Worker::query()->where('site_id', $siteId)->findOrFail($worker_id);

        // remove config of worker
        SuperUserApiService::remove_dir($this->workersDir . "/laravel-worker-{$worker->id}.conf");

        // remove record from db
        $worker->delete();

        // reload supervisor
        $this->reloadSupervisor();
    }

    //todo: move supervisor functions to container
    protected function reloadSupervisor(): void {
        // reload supervisor
        SuperUserAPIService::exec($this->siteName, 'supervisorctl reread');
        SuperUserAPIService::exec($this->siteName, 'supervisorctl update');
        SuperUserAPIService::exec($this->siteName, 'supervisorctl start laravel-worker:*');
    }

    public function restartSupervisor(): void {
        SuperUserAPIService::exec($this->siteName, 'service supervisor stop');
        SuperUserAPIService::exec($this->siteName, 'service supervisor start');
    }

    public function restartWorker(int $id) {
        SuperUserAPIService::exec($this->siteName, "supervisorctl restart worker-$id:");
    }

    public function getWorkerLog(int $id) {
        $result = SuperUserAPIService::exec($this->siteName, "cat /var/log/worker-$id.log");
        if($result['data'])
            return $result['data'];
        else
            return "No contents yet";
    }

    public function getWorkersStatus(){
        $result = SuperUserAPIService::exec($this->siteName, "supervisorctl status");
        if($result['data'])
            return $result['data'];
        else
            return "No workers is running";
    }
}
