<?php

namespace App\OpenAI\ChatBot;

use App\OpenAI\PromptProviders\PromptProvider;

interface ChatBot
{
    public function execute(
        string $method, 
        PromptProvider $prompt
    ): ChatBotResponse;
}