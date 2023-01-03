<?php

namespace App\OpenAI\PromptProviders;

interface PromptProvider
{
    public function toArray(): array;
}