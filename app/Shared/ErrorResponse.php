<?php

namespace App\Shared;

use Throwable;

class ErrorResponse extends Response
{
    public function __construct(private string $message, private ?Throwable $exception = null){}

    public function isError(): bool
    {
        return true;
    }

    public function getError(): string
    {
        return $this->message;
    }

    public function getException(): ?Throwable
    {
        return $this->exception;
    }

    public static function from(Throwable $exception): self
    {
        return new static($exception->getMessage(), $exception);
    }
}