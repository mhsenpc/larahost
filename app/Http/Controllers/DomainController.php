<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Site;
use App\Rules\FQDN;
use App\Services\ParkDomainService;
use App\Services\ReservedNamesService;
use App\Services\ReverseProxyService;
use Illuminate\Http\Request;

class DomainController extends Controller {
    public function index(Request $request, Site $site) {
        $domains = Domain::query()->where('site_id', $site->id)->get();
        return view('site.domains', compact('domains', 'site'));
    }

    public function parkDomain(Request $request, Site $site) {
        $request->validate([
            'name' => ['required','unique:domains',new FQDN()]
        ]);

        if(ParkDomainService::isDomainPointedToUs($request->name)){
            ParkDomainService::parkDomain($site,$request->name);
            return redirect()->back()->withInput(['دامنه '. $request->domain. ' با موفقیت به سرور شما متصل گردید']) ;
        }
        else{
            if (ReservedNamesService::isNameReserved($request->name)) {
                return redirect()->back()->withInput()->withErrors(['هنوز name server های دامنه شما به سمت سرور ما اشاره نمی کند']);
            }
        }
    }

    public function removeDomain(Request $request, Site $site) {
        Domain::query()->where('site_id', $site->id)->where('name', $request->name)->delete();
        $reverse_proxy_service = new ReverseProxyService($site);
        $reverse_proxy_service->removeDomainConfig($request->name);
        return redirect()->back();
    }

    public function enableSubDomain(Request $request, Site $site) {
        $site->subdomain_status = true;
        $site->save();

        $reverse_proxy_service = new ReverseProxyService($site);
        $reverse_proxy_service->writeNginxConfigs();
        return redirect()->back();
    }

    public function disableSubDomain(Request $request, Site $site) {
        $site->subdomain_status = false;
        $site->save();

        $reverse_proxy_service = new ReverseProxyService($site);
        $reverse_proxy_service->writeNginxConfigs();
        return redirect()->back();
    }

}
