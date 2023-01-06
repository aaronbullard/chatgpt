<?php

namespace App\OpenAI\Contracts;

use App\OpenAI\ChatBot\Usage;

interface Logger
{
    public function log(int $profileId, string $promptProviderName, Usage $usage);
}