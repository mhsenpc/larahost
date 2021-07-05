<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;

class ReverseProxyService
{
    protected $conf_d_path= '/etc/nginx/conf.d';

    /**
     * @var string
     */
    protected $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    protected function generateConfig(int $port) {
        $template = Storage::get('nginx_vhost.template');
        $template = str_replace('$project_name', $this->name, $template);
        $template = str_replace('$port', $port, $template);

        file_put_contents("{$this->conf_d_path}/{$this->name}.conf", $template);
    }

    public function reloadNginx() {
        $output = SuperUserAPIService::reload_nginx();
        \Log::debug("nginx reload");
        \Log::debug($output);
    }

    public function setupNginx(int $port){
        $this->generateConfig($port);
        $this->reloadNginx();
    }

    public function removeSiteConfig(string $email){
        $output = SuperUserAPIService::remove_site($email,$this->name);
    }
}
