<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;

class ReverseProxyService
{
    protected $binary = "/usr/sbin/nginx";
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $port;

    public function __construct(string $name, int $port) {
        $this->name = $name;
        $this->port = $port;
    }

    protected function generateConfig() {
        $template = Storage::get('nginx_vhost.template');
        $template = str_replace('$project_name', $this->name, $template);
        $template = str_replace('$port', $this->port, $template);

        file_put_contents("/etc/nginx/conf.d/{$this->name}.conf", $template);
    }

    protected function reloadNginx() {
        exec("{$this->binary} -s reload 2>&1",$output);
        \Log::debug("nginx reload");
        \Log::debug($output);
    }

    public function setupNginx(){
        $this->generateConfig();
        $this->reloadNginx();
    }
}
