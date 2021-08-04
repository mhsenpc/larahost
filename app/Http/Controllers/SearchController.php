<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $site = Site::query()->where('name',$request->site_name)->first();
        if($site){
            return redirect(route('sites.show',compact('site')));
        }
        else{
            return redirect()->back()->withInput()->withErrors(['متاسفانه سایتی با نام ' . $request->site_name. " پیدا نشد"]);
        }
    }
}
