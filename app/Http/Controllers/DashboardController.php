<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $isAdmin = Auth::user()->isAdmin();
        if ($isAdmin) {
            $usersCount = User::query()->count();
            $sitesCount = Site::query()->count();
            $domainsCount = Domain::query()->count();
            return view('dashboard', compact('isAdmin', 'usersCount', 'sitesCount', 'domainsCount'));
        } else {
            return view('dashboard');
        }
    }
}
