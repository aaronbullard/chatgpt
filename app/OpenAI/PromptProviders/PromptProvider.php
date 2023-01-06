<?php

namespace App\OpenAI\PromptProviders;

interface PromptProvider
{
    public function getProfileId(): int;
    public function toArray(): array;
}