<?php


namespace App\Services;


use App\Models\Worker;
use Illuminate\Support\Facades\Storage;

class QueueService {
    /**
     * @var \App\Models\Site
     */
    protected $site;

    protected $workers_path;

    public function __construct(\App\Models\Site $site) {
        $this->site = $site;
        $this->workers_path = PathHelper::getWorkersDir($this->site->user->email, $this->site->name);
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
        file_put_contents($this->workers_path . "/laravel-worker-{$worker->id}.conf", $template);
        $this->reloadSupervisor();

    }

    public function removeWorker(int $worker_id) {
        $worker = Worker::query()->where('site_id', $this->site->id)->findOrFail($worker_id);

        // remove config of worker
        unlink($this->workers_path . "/laravel-worker-{$worker->id}.conf");

        // remove record from db
        $worker->delete();

        // reload supervisor
        $this->reloadSupervisor();
    }

    public function reloadSupervisor(): void {
        // reload supervisor
        SuperUserAPIService::exec_command($this->site->name, 'supervisorctl reread');
        SuperUserAPIService::exec_command($this->site->name, 'supervisorctl update');
        SuperUserAPIService::exec_command($this->site->name, 'supervisorctl start laravel-worker:*');
    }

    public function restartSupervisor(): void {
        SuperUserAPIService::exec_command($this->site->name, 'service supervisor restart');
    }

    public function restartWorker(int $id) {
        SuperUserAPIService::exec_command($this->site->name, "supervisorctl restart worker-$id:");
    }

    public function getWorkerLog(int $id) {
        $result = SuperUserAPIService::exec_command($this->site->name, "cat /var/log/worker-$id.log");
        return $result->data;
    }

    public function getWorkersStatus(){
        $result = SuperUserAPIService::exec_command($this->site->name, "supervisorctl status");
        return $result->data;
    }
}
