<?php


namespace App\Traits;


use App\Events\Site\Created;
use App\Events\Site\Creating;
use App\Events\Site\Deployed;
use App\Events\Site\Deploying;
use App\Services\CommandLog;
use App\Services\LaravelDeployCommands;
use Illuminate\Support\Facades\Log;

trait DeployTrait {
    public function firstDeploy() {
        Log::debug("first deploy");
        $this->getFilesystem()->createRequiredDirectories();
        $container = $this->getContainer()->create($this->getPort());
        $commandLog = new CommandLog($this->getName());
        if ($container->waitForWakeUp()) {
            $result = $this->getRepository()->cloneRepo($this->getModel()->repo, $this->getModel()->git_user, $this->getModel()->git_password);
            if ($result['success']) {
                $commandLog->addFrom($result['logs']);
                $commandLog->addFrom($this->getApplication()->setup());;
                $this->getDomain()->add($this->getName() . '.lara-host.ir');
                $this->getLogWriter()->write($commandLog, true);
            } else {
                $commandLog->add("git clone {$this->getModel()->repo} .", "Failed to clone the repository with the provided credentials");
                $this->getLogWriter()->write($commandLog, false);
            }
        } else {
            $commandLog->add("site new {$this->getName()}", "Unable to setup a new site. Contact Administrator");
            $this->getLogWriter()->write($commandLog, false);
            Log::critical("failed to create new container {$this->getName()}");
        }
        Created::dispatch($this->getModel());
        Deployed::dispatch($this->getModel());
    }

    public function reDeploy() {
        $repoUrl = $this->getModel()->repo;
        $gitUser = $this->getModel()->git_user;
        $gitPass = $this->getModel()->git_password;

        $commandLog = new CommandLog($this->getName());
        // try pull. if there were any problems with pull, let's clone repo again
        $pullResult = $this->getRepository()->pull();
        if (!$pullResult['success']) {
            $cloneResult = $this->getRepository()->cloneRepo($repoUrl, $gitUser, $gitPass);
            $commandLog->addFrom($cloneResult['logs']);
        }

        if ($this->getRepository()->isvalid()) {
            $deployment_commands_service = new LaravelDeployCommands($this->getName(), $this->getModel()->deploy_commands);
            $commandLog->addFrom($deployment_commands_service->execute());;
        }

        $this->getLogWriter()->write($commandLog, $this->getRepository()->isvalid());
        Deployed::dispatch($this->getModel());
    }
}
