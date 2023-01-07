<?php

namespace App\OpenAI\Contracts;

use App\OpenAI\ChatBot\ChatBotResponse;

interface Logger
{
    public function log(int $profileId, string $promptProviderName, ChatBotResponse $response): void;
}