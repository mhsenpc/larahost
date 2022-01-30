<?php


namespace App\Http\Controllers\Admin;


use App\Models\Site;

class SitesController {
    public function index(){
        $sites = Site::query()->with(['user'])->orderBy('created_at','desc')->paginate();
        return view('admin.sites',compact('sites'));
    }

}
