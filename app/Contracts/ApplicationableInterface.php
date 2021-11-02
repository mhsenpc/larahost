<?php


namespace App\Contracts;


interface ApplicationableInterface {
    public function getApplication():ApplicationInterface;
}
