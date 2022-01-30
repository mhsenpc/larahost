<?php


namespace App\Contracts;


interface DomainInterface {
    public function add(string $domain);
    public function remove(string $domain);
}
