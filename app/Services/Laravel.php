<?php


namespace App\Services;


use App\Contracts\ApplicationInterface;

class Laravel implements ApplicationInterface {
    private string $siteName;
    private string $workersDir;

    public function __construct(string $siteName, string $workersDir) {
        $this->siteName = $siteName;
        $this->workersDir = $workersDir;
    }

    public function getQueue(): Queue {
        return new Queue($this->siteName, $this->workersDir);
    }
}
