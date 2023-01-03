<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DomainException extends Exception
{
    public static function from(Throwable $e): self
    {
        return new static($e->getMessage(), $e->getCode(), $e);
    }
}