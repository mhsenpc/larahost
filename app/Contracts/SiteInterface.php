<?php


namespace App\Contracts;


interface SiteInterface {
    public function getFilesystem(): FileSystemInterface;

    public function getRepository(): RepositoryInterface;

    public function getContainer(): ContainerInterface;

    public function getSubDomain(): DomainInterface;

    public function getApplication(): ApplicationInterface;
}
