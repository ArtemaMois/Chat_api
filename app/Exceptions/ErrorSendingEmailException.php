<?php

namespace App\Exceptions;

use Exception;

class ErrorSendingEmailException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
}
