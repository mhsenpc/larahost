<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $is_admin = Auth::user()->isAdmin();
        if($is_admin){
            $users_count = User::query()->count();
            $sites_count = Site::query()->count();
            return view('dashboard',compact('is_admin','users_count','sites_count'));
        }
        else{
            return view('dashboard');
        }
    }
}
