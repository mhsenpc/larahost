<?php


namespace App\Repositories;


class RepositoryAbstract {
    protected $model;

    public function insert(array $items) {
        return $this->model::create($items);
    }
}
