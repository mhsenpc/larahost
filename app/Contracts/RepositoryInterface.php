<?php


namespace App\Contracts;


interface RepositoryInterface {
    public function cloneRepo(string $repoUrl,string $gitUser,string $gitPass);
    public function pull();
    public function isvalid():bool;
}
