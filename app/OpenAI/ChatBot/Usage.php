<?php

namespace App\OpenAI\ChatBot;

use RangeException;

class Usage
{
    public function __construct(
        private int $totalTokens,
        private int $promptTokens, 
        private int $completionTokens = 0,
    ){
        $this->validate();
    }

    public function totalTokens(): int
    {
       return $this->totalTokens;
    }

    public function promptTokens(): int
    {
        return $this->promptTokens;
    }

    public function completionTokens(): int
    {
        return $this->completionTokens;
    }

    private function validate(): void
    {
        if ($this->promptTokens() + $this->completionTokens() !== $this->totalTokens()) {
            throw new RangeException('Prompt and Completion tokens do not match Total tokens.');
        }
    }
}