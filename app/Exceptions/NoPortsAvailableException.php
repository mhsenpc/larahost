<?php

namespace App\Exceptions;

use Exception;

class NoPortsAvailableException extends Exception
{
    protected $message = "There is no more free port available on this server";
}
