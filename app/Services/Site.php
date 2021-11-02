<?php


namespace App\Services;


use App\Contracts\ApplicationableInterface;
use App\Contracts\ApplicationInterface;
use App\Contracts\ContainerInterface;
use App\Contracts\DomainInterface;
use App\Contracts\FileSystemInterface;
use App\Contracts\RepositoryInterface;
use App\Contracts\SiteInterface;
use App\Models\User;

class Site implements SiteInterface, ApplicationableInterface {
    private \App\Models\Site $model;

    public function __construct(\App\Models\Site $model) {
        $this->model = $model;
    }

    public static function createFromSiteId(int $id): Site {
        $siteModel = \App\Models\Site::find($id);
        return new Site($siteModel);
    }

    /**
     * @return \App\Models\Site
     */
    public function getModel(): \App\Models\Site {
        return $this->model;
    }

    public function getName(): string {
        return $this->model->name;
    }

    public function getUser(): User {
        return $this->model->user;
    }

    public function getFilesystem(): FileSystemInterface {
        return new Filesystem($this->getUser()->email, $this->getName());
    }

    public function getRepository(): RepositoryInterface {
        return new Repository($this->getModel(), $this->getName(), $this->getFilesystem()->getSourceDir());
    }

    public function getContainer(): ContainerInterface {
        return new Container($this->getName(), $this->getFilesystem());
    }

    public function getApplication(): ApplicationInterface {
        // TODO: Implement getApplication() method.
    }

    public function getDomain(): DomainInterface {
        // TODO: Implement getDomain() method.
    }
}
