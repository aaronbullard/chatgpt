<?php

namespace App\OpenAI\ChatBot;

use App\OpenAI\Contracts\Logger;
use App\OpenAI\PromptProviders\PromptProvider;

class UsageLoggerChatBot implements ChatBot
{
    public function __construct(private ChatBot $chatBot, private Logger $logger){}

    public function execute(string $method, PromptProvider $promptProvider): ChatBotResponse
    {
        $response = $this->chatBot->execute($method, $promptProvider);

        if ($response->isError()) {
            return $response;
        }

        $this->logger->log(
            $promptProvider->getProfileId(),
            get_class($promptProvider),
            $response->getUsage()
        );

        return $response;
    }
}