<?php

namespace App\OpenAI\PromptProviders;

class Answer
{
    public function __construct(
        private string $response,
        private Meta $meta
    ){}
    
    public function getResponse(): string
    {
        return $this->response;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }
}