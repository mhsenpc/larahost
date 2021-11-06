<?php


namespace App\Contracts;


interface ContainerInterface {
    public function waitForWakeUp(int $maxTries);

    public function isRunning(): bool;

    public function up();

    public function down();
}
