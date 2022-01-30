<?php


namespace App\Services;


class Hosting {
    public static function isNameReserved(string $name) {
        return in_array($name, config('larahost.domain.reserved_sudomains'));
    }
}
