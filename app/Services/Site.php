<?php


namespace App\Services;


use App\Contracts\ApplicationInterface;
use App\Contracts\ContainerInterface;
use App\Contracts\DomainInterface;
use App\Contracts\FileSystemInterface;
use App\Contracts\RepositoryInterface;
use App\Contracts\SiteInterface;
use App\Models\Domain;
use App\Models\User;

class Site implements SiteInterface {
    private \App\Models\Site $model;

    public function __construct(\App\Models\Site $modelModel) {
        $this->model = $modelModel;
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
        return new Laravel($this->getName(), $this->getFilesystem(), $this->getContainer()->getSupervisor());
    }

    public function getDomain(): DomainInterface {
        // TODO: Implement getDomain() method.
    }

    public function destroy() {
        $this->getContainer()->down();

        // remove contents
        $output = SuperUserAPIService::remove_dir($this->getFilesystem()->getProjectBaseDir());

        $this->getModel()->domains()->delete();

        // remove nginx config
        $reverse_proxy_service = new ReverseProxyService($this->getModel());
        $reverse_proxy_service->removeNginxConfigs();

        // remove database record
        $this->getModel()->delete();
    }
}
