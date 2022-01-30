<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class DemologinController extends Controller {
    public function index() {
        $user = User::where('email', 'demo@lara-host.ir')->first();

        Auth::loginUsingId($user->id);
        return route('dashboard');
    }
}
