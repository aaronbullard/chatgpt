<?php

namespace App\Shared;

abstract class Response 
{
    abstract public function isError(): bool;
}