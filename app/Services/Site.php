<?php


namespace App\Services;


use App\Contracts\ApplicationInterface;
use App\Contracts\ContainerInterface;
use App\Contracts\DomainInterface;
use App\Contracts\FileSystemInterface;
use App\Contracts\RepositoryInterface;
use App\Contracts\SiteInterface;
use App\Models\User;
use App\Traits\DeployTrait;
use App\Traits\DestroyTrait;

class Site implements SiteInterface {
    private \App\Models\Site $model;
    use DeployTrait;
    use DestroyTrait;

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

    public function getPort(): int {
        return $this->model->port;
    }

    public function getUser(): User {
        return $this->model->user;
    }

    public function getFilesystem(): FileSystemInterface {
        return new Filesystem($this->getUser()->email, $this->getName());
    }

    public function getRepository(): RepositoryInterface {
        return new Repository($this->getName(), $this->getFilesystem()->getSourceDir());
    }

    public function getContainer(): ContainerInterface {
        return new Container($this->getName(), $this->getFilesystem());
    }

    public function getApplication(): ApplicationInterface {
        $deployCommands = $this->model->deploy_commands;
        return new Laravel($this->getName(), $this->getFilesystem(), $this->getContainer()->getSupervisor(),$deployCommands);
    }

    public function getDomain(): DomainInterface {
        return new Domain($this->model);
    }

    public function getSubDomain(): DomainInterface {
        return new SubDomain($this->getPort());
    }

    protected function getLogWriter(){
        return new LogWriter($this->getModel()->id,$this->getFilesystem()->getDeploymentLogsDir());
    }
}
