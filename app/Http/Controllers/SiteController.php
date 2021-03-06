<?php

namespace App\Http\Controllers;

use App\Events\Site\Deploying;
use App\Jobs\RedeploySiteJob;
use App\Models\Deployment;
use App\Models\Site;
use App\Services\Hosting;
use App\Services\SiteFactory;
use App\Services\SuperUserAPIService;
use App\Services\TokenGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller {
    public function __construct(){
        $this->middleware('demouser.checkaction' )->only('store') ;
    }

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
        /*
         *  remove limitation
        $sitesCount = Site::query()->count();
        $allowNewSite = $sitesCount == 0;
        if (App::environment('local') || Auth::user()->isAdmin()) {
            $allowNewSite = true;
        }*/
        $allowNewSite = true;

        if (App::environment('local') || Auth::user()->isAdmin()) {
            $allowNewSite = true;
        }


        return view('site.create', compact('public_key', 'faker', 'allowNewSite'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->name = strtolower($request->name);
        $request->name = config('larahost.site_prefix') . $request->name;

        $request->validate([
            'name' => 'required|alpha_num|unique:sites',
            'repo' => 'required',
        ]);
        if (Hosting::isNameReserved($request->name)) {
            return redirect()->back()->withInput()->withErrors(['???????????????? ?????? ?????? ???????? ?????????????? ?????? ??????. ???????? ?????? ?????????? ???????????? ????????????']);
        }


        if (!App::environment('local') && !Auth::user()->isAdmin()) {
            if (Site::query()->count() > 0) {
                return response('forbidden', 403);
            }
        }


        $new_site_service = (new SiteFactory());
        $new_site_service->getSite(Auth::id(), $request->name, $request->repo, !empty($request->manual_credentials), $request->username, $request->password);
        return redirect(route('sites.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site) {
        $siteObj = new \App\Services\Site($site);
        $maintenace_status = $siteObj->getApplication()->getMaintenance()->isDown();
        $maintenace_secret = $siteObj->getApplication()->getMaintenance()->getSecret();
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
        $siteObj = new \App\Services\Site($site);
        $siteObj->destroy();
        return redirect(route('sites.index'));
    }

    public function factoryReset(Site $site) {
        $siteObj = new \App\Services\Site($site);
        $siteObj->getContainer()->rebuildContainers();
        return redirect()->back();
    }

    public function deployments(Site $site) {
        $deployments = Deployment::query()->where('site_id', $site->id)->get();
        return view('site.deployments', compact('deployments', 'site'));
    }

    public function logs(Site $site) {
        $siteObj = new \App\Services\Site($site);
        $logs_dir = $siteObj->getFilesystem()->getLaravelLogsDir();
        $logs = scandir($logs_dir);
        $logs = array_diff($logs, array('..', '.', '.gitignore')); //remove invalid files
        if (count($logs) == 1 && substr(reset($logs), -4) == '.log') {
            $file_name = reset($logs);
            $log_content = file_get_contents($logs_dir . '/' . $file_name);
            return view('site.show_laravel_log', compact('log_content', 'site', 'file_name'));
        } else {
            return view('site.laravel_logs', compact('logs', 'site'));
        }
    }

    public function redeploy(Site $site) {
        $siteObj = new \App\Services\Site($site);
        Deploying::dispatch($site);
        RedeploySiteJob::dispatch($siteObj);
        return redirect()->back();
    }

    public function save_deploy_commands(Request $request, Site $site) {
        $site->deploy_commands = $request->deploy_commands;
        $site->save();
        return redirect()->back();
    }

    public function env_editor(Site $site) {
        $siteObj = new \App\Services\Site($site);
        $env = $siteObj->getApplication()->getEnvFile();

        return view('site.env_editor', compact('site', 'env'));
    }

    public function handle_env_editor(Request $request, Site $site) {
        $siteObj = new \App\Services\Site($site);
        $siteObj->getApplication()->updateEnvFile($request->env);
        return redirect()->back();
    }

    public function regenerateDeployToken(Site $site) {
        $site->deploy_token = (new TokenGenerator())->generate();
        $site->save();
        return redirect()->back();
    }

    public function triggerDeployment(Request $request) {
        $request->validate([
            'token' => 'required|exists:sites,deploy_token'
        ]);
        $site = SiteFactory::getSiteByDeployToken($request->token);
        Deploying::dispatch($site->getModel());
        RedeploySiteJob::dispatch($site);
        return response()->json(['success' => true, 'message' => 'Deployment started for site ' . $site->getName()]);
    }

    public function maintenanceUp(Site $site) {
        $siteObj = new \App\Services\Site($site);
        $siteObj->getApplication()->getMaintenance()->up();
        return redirect()->back();
    }

    public function maintenanceDown(Request $request, Site $site) {
        $siteObj = new \App\Services\Site($site);
        $siteObj->getApplication()->getMaintenance()->down($request->secret);

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
