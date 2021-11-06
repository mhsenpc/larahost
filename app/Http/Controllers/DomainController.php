<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Site;
use App\Rules\FQDN;
use App\Services\Hosting;
use App\Services\ParkDomainService;
use App\Services\ReverseProxy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DomainController extends Controller {
    public function index(Request $request, Site $site) {
        $domains = Domain::query()->where('site_id', $site->id)->get();
        return view('site.domains', compact('domains', 'site'));
    }

    public function parkDomain(Request $request, Site $site) {
        $request->validate([
            'name' => ['required', 'unique:domains', new FQDN(), Rule::notIn(['lara-host.ir', 'ns1.lara-host.ir', 'ns2.lara-host.ir', 'my.lara-host.ir'])]
        ]);

        if (ParkDomainService::isDomainPointedToUs($request->name)) {
            ParkDomainService::parkDomain($site, $request->name);
            return redirect()->back()->withInput(['دامنه ' . $request->domain . ' با موفقیت به سرور شما متصل گردید']);
        } else {
            if (Hosting::isNameReserved($request->name)) {
                return redirect()->back()->withInput()->withErrors(['هنوز name server های دامنه شما به سمت سرور ما اشاره نمی کند']);
            }
        }
    }

    public function removeDomain(Request $request, Site $siteModel) {
        $domain = $siteModel->domains()->where('name', $request->name)->firstOrFail();
        $domain->delete();

        $site = new \App\Services\Site($siteModel);
        $site->getDomain()->remove($request->name);
        return redirect()->back();
    }

    public function enableSubDomain(Request $request, Site $siteModel) {
        $siteModel->subdomain_status = true;
        $siteModel->save();

        $site = new \App\Services\Site($siteModel);
        $domain = $site->getName() . ".lara-host.ir";
        $site->getDomain()->add($domain);
        return redirect()->back();
    }

    public function disableSubDomain(Request $request, Site $siteModel) {
        $siteModel->subdomain_status = false;
        $siteModel->save();

        $site = new \App\Services\Site($siteModel);
        $domain = $site->getName() . ".lara-host.ir";
        $site->getDomain()->remove($domain);
        return redirect()->back();
    }

}
