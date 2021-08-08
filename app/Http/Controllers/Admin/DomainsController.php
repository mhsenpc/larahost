<?php


namespace App\Http\Controllers\Admin;


use App\Models\Domain;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DomainsController {
    public function index(){
        $domains = Domain::query()->with(['site','site.user'])->orderBy('created_at','desc')->paginate();
        return view('admin.domains',compact('domains'));
    }

}
