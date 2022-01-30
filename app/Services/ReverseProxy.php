<?php


namespace App\Services;


use App\Models\Domain;
use App\Models\Site;
use Illuminate\Support\Facades\Storage;

class ReverseProxy {
    protected $conf_d_path = '/etc/nginx/conf.d';

    public function generateConfig(string $domain, int $port) {
        $template = Storage::get('nginx_vhost.template');
        $template = str_replace('$domain', $domain, $template);
        $template = str_replace('$port', $port, $template);

        SuperUserAPIService::put_contents("{$this->conf_d_path}/{$domain}.conf", $template);
    }

    public function reload() {
        $output = SuperUserAPIService::reload_nginx();
        \Log::debug("nginx reload");
        \Log::debug($output);
    }
}
