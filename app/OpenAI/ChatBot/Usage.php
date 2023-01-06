<?php

namespace App\OpenAI\ChatBot;

class Usage
{
    public function __construct(
        private int $promptTokens, 
        private int $completionTokens
    ){}

    public function promptTokens(): int
    {
        return $this->promptTokens;
    }

    public function completionTokens(): int
    {
        return $this->completionTokens;
    }

    public function totalTokens(): int
    {
        return $this->promptTokens() + $this->completionTokens();
    }
}