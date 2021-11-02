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

    public static function createFromSiteId(int $id):Site{
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

    public function createRequiredDirectories() {
        $repos_dir = config('larahost.repos_dir');

        /*
         * check if required directories exist
         */
        if (!is_dir($repos_dir)) {
            SuperUserAPIService::new_folder($repos_dir);
        }
        if (!is_dir($repos_dir . '/' . $this->getModel()->user->email)) {
            SuperUserAPIService::new_folder($repos_dir . '/' . $this->getModel()->user->email);
        }

        SuperUserAPIService::new_folder($this->getModel()->getProjectBaseDir());
        SuperUserAPIService::new_folder($this->getModel()->getSourceDir());
        SuperUserAPIService::new_folder($this->getModel()->getDeploymentLogsDir());
        SuperUserAPIService::new_folder($this->getModel()->getDockerComposeDir());
        SuperUserAPIService::new_folder($this->getModel()->getWorkersDir());
    }

    public function getFilesystem(): FileSystemInterface {
        // TODO: Implement getFilesystem() method.
    }

    public function getRepository(): RepositoryInterface {
        // TODO: Implement getRepository() method.
    }

    public function getContainer(): ContainerInterface {
        return new Container($this->getName(),$this->getFilesystem());
    }

    public function getApplication(): ApplicationInterface {
        // TODO: Implement getApplication() method.
    }

    public function getDomain(): DomainInterface {
        // TODO: Implement getDomain() method.
    }
}
