<?php


namespace App\Services;


use App\Models\Site;

class MaintenanceService {
    /**
     * @var Site
     */
    protected $site;

    public function __construct(\App\Models\Site $site) {

        $this->site = $site;
    }

    public function up() {
        SuperUserAPIService::exec($this->site->name, 'php artisan up');
    }

    public function down($secret) {
        $command = 'php artisan down';
        if (!empty($secret)) {
            $command .= " --secret=\"$secret\"";
        }

        SuperUserAPIService::exec($this->site->name, $command);
    }

    public function isDown() {
        $file_path = $this->getDownFilePath();
        return file_exists($file_path);
    }

    public function getSecret() {
        if ($this->isDown()) {
            $down = file_get_contents($this->getDownFilePath());
            $down = json_decode($down);
            if (isset($down->secret))
                return $down->secret;
        }
        return "";
    }

    protected function getDownFilePath() {
        return $this->site->getSourceDir() . "/storage/framework/down";
    }
}
