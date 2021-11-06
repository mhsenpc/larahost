<?php


namespace App\Contracts;


interface FileSystemInterface {
    public function createRequiredDirectories();
    public function getProjectBaseDir();
}
