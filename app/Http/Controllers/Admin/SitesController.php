<?php


namespace App\Http\Controllers\Admin;


use App\Models\Domain;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SitesController {
    public function index(){
        $sites = Site::query()->with(['user'])->orderBy('created_at','desc')->paginate();
        return view('admin.sites',compact('sites'));
    }

}
