<?php


namespace App\Contracts;


interface SiteInterface {
    public function start();
    public function stop();

    public function queue():QueueInterface;

}
