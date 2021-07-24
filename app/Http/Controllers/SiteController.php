<?php

namespace App\Http\Controllers;

use App\Jobs\RedeploySiteJob;
use App\Models\CommandHistory;
use App\Models\Deployment;
use App\Models\Site;
use App\Services\DockerComposeService;
use App\Services\MaintenanceService;
use App\Services\PathHelper;
use App\Services\ReservedNamesService;
use App\Services\SiteDestroyerService;
use App\Services\SiteService;
use App\Services\SuperUserAPIService;
use App\Services\TokenCreatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sites = Site::get();
        return view('site.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('site.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->name = strtolower($request->name);

        $request->validate([
            'name' => 'required|alpha_num|unique:sites',
            'repo' => 'required',
        ]);
        if (ReservedNamesService::isNameReserved($request->name)) {
            return redirect()->back()->withInput()->withErrors(['This name is used. Please choose another name']);
        }
        $site_service = (new SiteService(Auth::user()));
        $site = $site_service->newSite($request->name, $request->repo, !empty($request->manual_credentials), $request->username, $request->password);
        return redirect(route('sites.show', ['site' => $site]));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site) {
        $maintance_service = new MaintenanceService($site);
        $maintenace_status = $maintance_service->isDown();
        $maintenace_secret = $maintance_service->getSecret();
        return view('site.show', compact('site', 'maintenace_status', 'maintenace_secret'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function remove(Site $site) {
        $site_destroyer = new SiteDestroyerService($site);
        $site_destroyer->destroy();
        return redirect(route('sites.index'));
    }

    public function restartAll(Site $site) {
        $project_dir = PathHelper::getProjectBaseDir(Auth::user()->email, $site->name);
        $docker_compose_service = new DockerComposeService();
        $docker_compose_service->restart($site->name, $project_dir);
        return redirect()->back();
    }

    public function deployments(Site $site) {
        $deployments = Deployment::query()->where('site_id', $site->id)->get();
        return view('site.deployments', compact('deployments', 'site'));
    }

    public function logs(Site $site) {
        $logs_dir = PathHelper::getLaravelLogsDir(Auth::user()->email, $site->name);
        $logs = scandir($logs_dir);

        $logs = array_diff($logs, array('..', '.', '.gitignore')); //remove invalid files

        if (count($logs) == 1 && substr(reset($logs), -4) == '.log') {
            $file_name = reset($logs);
            $logs_dir = PathHelper::getLaravelLogsDir(Auth::user()->email, $site->name);
            $log_content = file_get_contents($logs_dir . '/' . $file_name);
            return view('site.show_laravel_log', compact('log_content', 'site', 'file_name'));
        } else {
            return view('site.laravel_logs', compact('logs', 'site'));
        }
    }

    public function redeploy(Site $site) {
        RedeploySiteJob::dispatch($site);
        return redirect()->back();
    }

    public function save_deploy_commands(Request $request, Site $site) {
        $site->deploy_commands = $request->deploy_commands;
        $site->save();
        return redirect()->back();
    }

    public function env_editor(Site $site) {
        $source_dir = PathHelper::getSourceDir(Auth::user()->email, $site->name);
        $env = '';
        if (file_exists($source_dir . '/.env')) {
            $env = file_get_contents($source_dir . '/.env');
        }

        return view('site.env_editor', compact('site', 'env'));
    }

    public function handle_env_editor(Request $request, Site $site) {
        $source_dir = PathHelper::getSourceDir(Auth::user()->email, $site->name);
        file_put_contents($source_dir . '/.env', $request->env);
        return redirect()->back();
    }

    public function regenerateDeployToken(Site $site) {
        $site->deploy_token = TokenCreatorService::generateDeployToken();
        $site->save();
        return redirect()->back();
    }

    public function triggerDeployment(Request $request) {
        $request->validate([
            'token' => 'required|exists:sites,deploy_token'
        ]);
        $site = Site::query()->withoutGlobalScopes()->where('deploy_token', $request->token)->firstOrFail();
        RedeploySiteJob::dispatch($site);
        return response()->json(['success' => true, 'message' => 'Deployment started for site ' . $site->name]);
    }

    public function maintenanceUp(Site $site) {
        $maintenance_service = new MaintenanceService($site);
        $maintenance_service->up();
        return redirect()->back();
    }

    public function maintenanceDown(Request $request, Site $site) {
        $maintenance_service = new MaintenanceService($site);
        $maintenance_service->down($request->secret);
        return redirect()->back();
    }

    public function updateGitRemote(Request $request, Site $site) {
        $site->repo = $request->repo;
        $site->save();
        return redirect()->back();
    }
}
