<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkDomainRequest;
use App\Models\Domain;
use App\Models\Site;
use App\Rules\FQDN;
use App\Services\Hosting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DomainController extends Controller {
    public function index(Request $request, Site $site) {
        $domains = Domain::query()->where('site_id', $site->id)->get();
        return view('site.domains', compact('domains', 'site'));
    }

    public function parkDomain(ParkDomainRequest $request, Site $site) {
        $siteObj = new \App\Services\Site($site);
        if ($siteObj->getDomain()->isDomainPointedToUs($request->name)) {
            $siteObj->getDomain()->add($request->name);
            return redirect()->back()->withInput(['دامنه ' . $request->name . ' با موفقیت به سرور شما متصل گردید']);
        } else {
            return redirect()->back()->withInput()->withErrors(['هنوز name server های دامنه شما به سمت سرور ما اشاره نمی کند']);
        }
    }

    public function removeDomain(Request $request, Site $site) {
        $domain = $site->domains()->where('name', $request->name)->firstOrFail();
        $domain->delete();

        $siteObj = new \App\Services\Site($site);
        $siteObj->getSubDomain()->remove($request->name);
        return redirect()->back();
    }

    public function enableSubDomain(Request $request, Site $site) {
        $site->subdomain_status = true;
        $site->save();

        $siteObj = new \App\Services\Site($site);
        $domain = $siteObj->getName() . config('larahost.sudomain');
        $siteObj->getSubDomain()->add($domain);
        return redirect()->back();
    }

    public function disableSubDomain(Request $request, Site $site) {
        $site->subdomain_status = false;
        $site->save();

        $siteObj = new \App\Services\Site($site);
        $domain = $siteObj->getName() . config('larahost.sudomain');
        $siteObj->getSubDomain()->remove($domain);
        return redirect()->back();
    }

}
