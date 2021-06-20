<?php


namespace App\Services;


class ReservedNamesService
{
    protected static $reserved_names
        = [
            'panel',
            'database',
            'redis'
        ];

    public static function isNameReserved(string $name) {
        return in_array($name, self::$reserved_names);
    }
}
