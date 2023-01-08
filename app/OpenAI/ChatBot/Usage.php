<?php

namespace App\OpenAI\ChatBot;

class Usage
{
    public function __construct(
        private int $totalTokens,
        private ?int $promptTokens = null, 
        private ?int $completionTokens = null,
        
    ){}

    public function totalTokens(): int
    {
       return $this->totalTokens;
    }

    public function promptTokens():?int
    {
        return $this->promptTokens;
    }

    public function completionTokens(): ?int
    {
        return $this->completionTokens;
    }
}