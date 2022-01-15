<?php

namespace App\Exceptions;

use Exception;

class WakeUpTimedOutException extends Exception
{
    protected $message = "Wait for container wake up timed out";
}
