<?php


namespace App\Contracts;


interface ContainerInterface {
    public function waitForWakeUp(int $maxTries);
}
