<?php

namespace App\OpenAI\ChatBot;

use stdClass;
use App\OpenAI\PromptProviders\PromptProvider;

interface ChatBot
{
    public function execute(string $method, PromptProvider $prompt): stdClass;
}