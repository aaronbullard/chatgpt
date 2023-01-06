<?php

namespace App\Shared;

class SuccessResponse extends Response
{
    public function isError(): bool
    {
        return false;
    }
}