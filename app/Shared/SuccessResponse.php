<?php

namespace App\Shared;

class SuccessResponse implements Response
{
    public function isError(): bool
    {
        return false;
    }
}