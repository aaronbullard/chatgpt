<?php

namespace App\OpenAI\ChatBot;

use App\OpenAI\PromptProviders\PromptProvider;
use stdClass;

class RateLimitChatBot implements ChatBot
{
    public function __construct(private ChatBot $chatBot, private $limiter){}

    public function execute(string $method, PromptProvider $providerPrompt): stdClass
    {
        // Do an update to check for rate limit

        return $this->chatBot->execute($method, $providerPrompt);
    }

    public static function getKey(int $businessId): string
    {
        return "openai-chatbot-biz-" . $businessId;
    }
}