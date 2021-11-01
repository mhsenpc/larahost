<?php


namespace App\Services;


class Container {
    private string $siteName;

    public function __construct(string $siteName) {
        $this->siteName = $siteName;
    }

    public function waitForWakeUp() {
        $i = 0;
        while (!SuperUserAPIService::exec($this->siteName, "ls")['success']) {
            $i++;
            sleep(2000);
            if ($i > 30) {
                return false;
            }
        }
        return true;
    }
}
