<?php

namespace App\OpenAI\Services;

use App\Shared\SuccessResponse;

class BusinessDescriptionResponse extends SuccessResponse
{
    public function __construct(
        public readonly string $description,
        public readonly array $body
    ){}

    public function getDescription(): string
    {
        return $this->description;
    }
}