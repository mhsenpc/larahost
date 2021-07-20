<?php

namespace App\Http\Controllers;

use App\Jobs\RedeploySiteJob;
use App\Models\Deployment;
use App\Models\Site;
use App\Services\ContainerInfoService;
use App\Services\DockerComposeService;
use App\Services\PathHelper;
use App\Services\ReservedNamesService;
use App\Services\SiteDestroyerService;
use App\Services\SiteService;
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
        return view('site.show', compact('site'));
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
        return view('site.deployments', compact('deployments','site'));
    }

    public function logs(Site $site) {
        $logs_dir = PathHelper::getLaravelLogsDir(Auth::user()->email, $site->name);
        $logs = scandir($logs_dir);

        $logs = array_diff($logs, array('..', '.', '.gitignore')); //remove invalid files

        if (count($logs) == 1 && reset($logs) == "laravel.log") {
            $logs_dir = PathHelper::getLaravelLogsDir(Auth::user()->email, $site->name);
            $log_content = file_get_contents($logs_dir . '/laravel.log');
            return view('site.show_laravel_log', compact('log_content','site'));
        } else {
            return view('site.laravel_logs', compact('logs','site'));
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
}
