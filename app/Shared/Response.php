<?php

namespace App\Shared;

interface Response 
{
    public function isError(): bool;
}