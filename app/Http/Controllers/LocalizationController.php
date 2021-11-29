<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\facades\App;

class LocalizationController extends Controller
{
    public function index($locale)
    {
        App::setlocale($locale);
        session()->put('locale',$locale);
        return redirect()->back();
    }
}
