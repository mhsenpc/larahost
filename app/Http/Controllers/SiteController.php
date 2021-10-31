<?php

namespace App\Http\Controllers;

use App\Jobs\RedeploySiteJob;
use App\Models\CommandHistory;
use App\Models\Deployment;
use App\Models\Domain;
use App\Models\Site;
use App\Services\DockerComposeService;
use App\Services\MaintenanceService;
use App\Services\PathHelper;
use App\Services\ReservedNamesService;
use App\Services\SiteDestroyerService;
use App\Services\NewSiteService;
use App\Services\SuperUserAPIService;
use App\Services\TokenCreatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;

class SiteController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sites = Site::query()->paginate();
        return view('site.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user_public_key = Auth::user()->getSSHKeysDir() . '/id_rsa.pub';
        $public_key = "";
        if (file_exists($user_public_key)) {
            $public_key = file_get_contents($user_public_key);
        }
        $faker = Faker::create();
        $sitesCount = Site::query()->count();
        $allowNewSite =  $sitesCount == 0 ;

        if (App::environment('local') || Auth::user()->isAdmin()) {
            $allowNewSite = true;
        }


        return view('site.create', compact('public_key', 'faker', 'allowNewSite','sitesCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->name = strtolower($request->name);
        $request->name = config('larahost.site_prefix').$request->name;

        $request->validate([
            'name' => 'required|alpha_num|unique:sites',
            'repo' => 'required',
        ]);
        if (ReservedNamesService::isNameReserved($request->name)) {
            return redirect()->back()->withInput()->withErrors(['متاسفانه این نام قبلا استفاده شده است. لطفا نام دیگری انتخاب نمایید']);
        }


        if (!App::environment('local') && !Auth::user()->isAdmin()) {
            if (Site::query()->count() > 0) {
                return response('forbidden', 403);
            }
        }


        $new_site_service = (new NewSiteService(Auth::user()));
        $site = $new_site_service->newSite($request->name, $request->repo, !empty($request->manual_credentials), $request->username, $request->password);
        return redirect(route('sites.index'));
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

    public function factoryReset(Site $site) {
        $docker_compose_service = new DockerComposeService($site);
        $docker_compose_service->rebuildContainers();
        return redirect()->back();
    }

    public function deployments(Site $site) {
        $deployments = Deployment::query()->where('site_id', $site->id)->get();
        return view('site.deployments', compact('deployments', 'site'));
    }

    public function logs(Site $site) {
        $logs_dir = PathHelper::getLaravelLogsDir($site->user->email, $site->name);
        $logs = scandir($logs_dir);

        $logs = array_diff($logs, array('..', '.', '.gitignore')); //remove invalid files

        if (count($logs) == 1 && substr(reset($logs), -4) == '.log') {
            $file_name = reset($logs);
            $logs_dir = PathHelper::getLaravelLogsDir($site->user->email, $site->name);
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
        $source_dir = $site->getSourceDir();
        $env = '';
        if (file_exists($source_dir . '/.env')) {
            $env = file_get_contents($source_dir . '/.env');
        }

        return view('site.env_editor', compact('site', 'env'));
    }

    public function handle_env_editor(Request $request, Site $site) {
        SuperUserAPIService::put_contents($site->getSourceDir() . '/.env', $request->env);
        SuperUserAPIService::exec($site->name, 'php artisan config:clear');
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

    public function restartApache(Request $request, Site $site) {
        SuperUserAPIService::restart_container($site->name);
        return redirect()->back();
    }

    public function restartMySql(Request $request, Site $site) {
        SuperUserAPIService::restart_container("{$site->name}_db");
        return redirect()->back();
    }

    public function restartRedis(Request $request, Site $site) {
        SuperUserAPIService::restart_container("{$site->name}_redis");
        return redirect()->back();
    }
}
