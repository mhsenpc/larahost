<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Services\ContainerInfoService;
use App\Services\ContainerService;
use App\Services\ReservedNamesService;
use App\Services\SiteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sites = Site::query()->where('user_id', Auth::id())->get();
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
        $request->validate([
            'name' => 'required|alpha_dash|unique:sites',
            'repo' => 'required',
        ]);
        if(ReservedNamesService::isNameReserved($request->name)){
            return redirect()->back()->withInput()->withErrors(['This name is used. Please choose another name']);
        }
        $site_service = (new SiteService(Auth::user()));
        $site_service->newSite($request->name, $request->repo);
        return redirect(route('sites.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site) {
        $running = ContainerInfoService::getPowerStatus($site->name);
        return view('site.show',compact('site','running'));
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
    public function destroy(Site $site) {
        //
    }

    public function start(Request $request){
        ContainerService::start($request->name);
        return redirect()->back();
    }

    public function stop(Request $request){
        ContainerService::stop($request->name);
        return redirect()->back();
    }

    public function restart(Request $request){
        ContainerService::restart($request->name);
        return redirect()->back();
    }
}
