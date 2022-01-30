<?php


namespace App\Services;


class Supervisor {
    private string $siteName;

    public function __construct(string $siteName) {
        $this->siteName = $siteName;
    }

    public function reload(): void {
        SuperUserAPIService::exec($this->siteName, 'supervisorctl reread');
        SuperUserAPIService::exec($this->siteName, 'supervisorctl update');
        SuperUserAPIService::exec($this->siteName, 'supervisorctl start laravel-worker:*');
    }

    public function restart(): void {
        SuperUserAPIService::exec($this->siteName, 'service supervisor stop');
        SuperUserAPIService::exec($this->siteName, 'service supervisor start');
    }

    public function restartWorker(int $id) {
        SuperUserAPIService::exec($this->siteName, "supervisorctl restart worker-$id:");
    }

    public function getStatus(){
        $result = SuperUserAPIService::exec($this->siteName, "supervisorctl status");
        if($result['data'])
            return $result['data'];
        else
            return "No workers is running";
    }
}
