<?php


namespace App\Services;


class Hosting {
    //todo: port finder
    //todo: reservse proxy
    // superuser api

    public static function isNameReserved(string $name) {
        return in_array($name, config('larahost.domain.reserved_sudomains'));
    }
}
