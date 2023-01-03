<?php

namespace App\OpenAI\Services;

class BusinessDescriptionRequest
{
    public function __construct(
        public readonly int $businessId,
        public readonly string $description
    ){}
}