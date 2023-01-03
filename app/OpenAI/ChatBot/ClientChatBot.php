<?php

namespace App\OpenAI\ChatBot;

use stdClass;
use Throwable;
use App\OpenAI\Exceptions\ChatBotClientException;
use App\OpenAI\PromptProviders\PromptProvider;

class ClientChatBot implements ChatBot
{
    public function __construct(private OpenAIGateway $client){}

    /**
     * Execute the api call to OpenAI
     *
     * @param string $method
     * @param PromptProvider $promptProvider
     * @throws ChatBotClientException
     * @return stdClass
     */
    public function execute(string $method, PromptProvider $promptProvider): stdClass
    {
        try {
            return $this->client->$method($promptProvider->toArray());
        } catch (Throwable $e) {
            throw ChatBotClientException::from($e);
        }
    }
}