<?php

namespace App\OpenAI\ChatBot;

use App\OpenAI\Contracts\UsageChecker;
use App\OpenAI\Exceptions\UsageLimitException;
use App\OpenAI\PromptProviders\PromptProvider;

class UsageLimitChatBot implements ChatBot
{
    public function __construct(private ChatBot $chatBot, private UsageChecker $checker){}

    public function execute(string $method, PromptProvider $providerPrompt): ChatBotResponse
    {
        if (!$this->checker->usageAvailable($providerPrompt->getProfileId())) {
            throw new UsageLimitException(UsageLimitException::LIMIT_REACHED);
        }

        $response = $this->chatBot->execute($method, $providerPrompt);

        $this->checker->recordUsage(
            $providerPrompt->getProfileId(),
            $response->getUsage()
        );

        return $response;
    }
}