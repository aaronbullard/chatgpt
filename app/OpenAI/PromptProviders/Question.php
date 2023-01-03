<?php

namespace App\OpenAI\PromptProviders;

class Question
{
    public function __construct(
        private int $businessId,
        private string $request
    ){}
    
    public function getBusinessId(): string
    {
        return (string) $this->businessId;
    }

    public function getRequest(): string
    {
        return $this->request;
    }
}