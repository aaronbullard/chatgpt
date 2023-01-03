<?php

namespace App\OpenAI\Services;

use App\OpenAI\ChatBot\Meta;

class BusinessDescriptionResponse
{
    public function __construct(
        public readonly string $description,
        public readonly Meta $meta
    ){}
}