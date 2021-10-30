<?php


namespace App\Services;


use App\Models\Worker;
use Illuminate\Support\Facades\Storage;

class QueueService {
    /**
     * @var \App\Models\Site
     */
    protected $site;

    public function __construct(\App\Models\Site $site) {
        $this->site = $site;
    }

    public function createWorker(string $connection, string $queue, int $sleep, int $tries, int $timeout, int $num_procs) {
        // insert record in db
        $worker = Worker::query()->create([
            'connection' => $connection,
            'queue' => $queue,
            'sleep' => $sleep,
            'tries' => $tries,
            'timeout' => $timeout,
            'num_procs' => $num_procs,
            'site_id' => $this->site->id
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
        SuperUserAPIService::new_file($this->site->getWorkersDir() . "/laravel-worker-{$worker->id}.conf", $template);
        $this->reloadSupervisor();

    }

    public function removeWorker(int $worker_id) {
        $worker = Worker::query()->where('site_id', $this->site->id)->findOrFail($worker_id);

        // remove config of worker
        SuperUserApiService::remove_dir($this->site->getWorkersDir() . "/laravel-worker-{$worker->id}.conf"); //todo: change api name

        // remove record from db
        $worker->delete();

        // reload supervisor
        $this->reloadSupervisor();
    }

    public function reloadSupervisor(): void {
        // reload supervisor
        SuperUserAPIService::exec($this->site->name, 'supervisorctl reread');
        SuperUserAPIService::exec($this->site->name, 'supervisorctl update');
        SuperUserAPIService::exec($this->site->name, 'supervisorctl start laravel-worker:*');
    }

    public function restartSupervisor(): void {
        SuperUserAPIService::exec($this->site->name, 'service supervisor stop');
        SuperUserAPIService::exec($this->site->name, 'service supervisor start');
    }

    public function restartWorker(int $id) {
        SuperUserAPIService::exec($this->site->name, "supervisorctl restart worker-$id:");
    }

    public function getWorkerLog(int $id) {
        $result = SuperUserAPIService::exec($this->site->name, "cat /var/log/worker-$id.log");
        if($result['data'])
            return $result['data'];
        else
            return "No contents yet";
    }

    public function getWorkersStatus(){
        $result = SuperUserAPIService::exec($this->site->name, "supervisorctl status");
        if($result['data'])
            return $result['data'];
        else
            return "No workers is running";
    }
}
