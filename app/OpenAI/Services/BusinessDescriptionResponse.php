<?php

namespace App\OpenAI\Services;

use App\Shared\SuccessResponse;

class BusinessDescriptionResponse extends SuccessResponse
{
    public function __construct(
        private string $description,
        private array $body
    ){}

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}