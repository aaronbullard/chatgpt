<?php

namespace App\OpenAI\Contracts;

use App\OpenAI\ChatBot\ChatBotResponse;

interface Logger
{
    /**
     * Create and persist instance to chat log
     *
     * @param integer $profileId
     * @param string $promptProvider
     * @param ChatBotResponse $response
     * @throws ChatLogException
     * @return int Record id
     */
    public function log(
        int $profileId, 
        string $promptProviderName, 
        ChatBotResponse $response
    ): int;
}