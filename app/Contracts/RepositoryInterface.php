<?php


namespace App\Contracts;


interface RepositoryInterface {
    public function cloneRepo();
    public function pull();
    public function isvalid():bool;
}
