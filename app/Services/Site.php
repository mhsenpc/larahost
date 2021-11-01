<?php


namespace App\Services;


use App\Models\User;

class Site {
    private \App\Models\Site $model;

    public function __construct(\App\Models\Site $model) {
        $this->model = $model;
    }

    /**
     * @return \App\Models\Site
     */
    public function getModel(): \App\Models\Site {
        return $this->model;
    }

    public function getName():string{
        return $this->model->name;
    }

    public function getUser():User{
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
}
