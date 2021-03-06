<?php


namespace App\Traits;


use App\Events\Site\DeployFailed;
use App\Events\Site\Created;
use App\Events\Site\Deployed;
use App\Services\CommandLog;
use App\Services\LaravelDeployCommands;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

trait DeployTrait {
    public function firstDeploy() {
        if (App::environment('local'))
            return true;
        $this->getFilesystem()->createRequiredDirectories();
        $container = $this->getContainer()->create($this->getUser(),$this->getPort() );
        $commandLog = new CommandLog($this->getName());
        try {
            $container->waitForWakeUp();
            $result = $this->getRepository()->cloneRepo($this->getModel()->repo, $this->getModel()->git_user, $this->getModel()->git_password);

            if ($result['success']) {
                $commandLog->addFrom($result['logs']);
                $commandLog->addFrom($this->getApplication()->setup());;
                $this->getSubDomain()->add($this->getName());
                $this->getLogWriter()->write($commandLog, true);
            } else {
                $message = "Failed to clone the repository with the provided credentials"; //send event message deployfailed
                $commandLog->add("git clone {$this->getModel()->repo} .", $message);
                $this->getLogWriter()->write($commandLog, false);

                event(new DeployFailed($this->getModel(), $message)); //send event deployfailed

            }
        }
        catch (\Exception $exception){
            $message = "Unable to setup a new site. Contact Administrator";
            $commandLog->add("site new {$this->getName()}", $message);

            $this->getLogWriter()->write($commandLog, false);

            event(new DeployFailed($this->getModel(), $message)); //send event deployfailed

            Log::critical("failed to create new container {$this->getName()}");
        }

        event(new Created($this->getModel()));
        event(new Deployed($this->getModel()));
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
