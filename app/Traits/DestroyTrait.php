<?php


namespace App\Traits;


trait DestroyTrait {
    public function destroy() {
        $this->getContainer()->down();

        // remove domains
        $domains = $this->model->domains()->get();
        foreach ($domains as $domain) {
            $this->getSubDomain()->remove($domain);
        }

        // remove subdomains
        $this->getSubDomain()->remove($this->getName(). config('larahost.sudomain'));
        $this->getModel()->domains()->delete();

        // remove database record
        $this->getModel()->delete();

        $this->getFilesystem()->removeAllSiteFiles();
    }
}
