<?php


namespace App\Services;


use App\Models\Site;

class Maintenance {
    private string $siteName;
    private string $sourceDir;

    public function __construct(string $siteName, string $sourceDir) {
        $this->siteName = $siteName;
        $this->sourceDir = $sourceDir;
    }

    public function up() {
        SuperUserAPIService::exec($this->siteName, 'php artisan up');
    }

    public function down($secret) {
        $command = 'php artisan down';
        if (!empty($secret)) {
            $command .= " --secret=\"$secret\"";
        }

        SuperUserAPIService::exec($this->siteName, $command);
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
        return $this->sourceDir . "/storage/framework/down";
    }
}
