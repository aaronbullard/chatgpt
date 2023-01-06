<?php

namespace App\OpenAI\ChatBot;

use Throwable;
use App\OpenAI\Exceptions\ChatBotClientException;
use App\OpenAI\Gateways\OpenAIGateway;
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
     * @return ChatBotResponse
     */
    public function execute(string $method, PromptProvider $promptProvider): ChatBotResponse
    {
        try {
            $response = new ChatBotResponse(
                $this->client->$method($promptProvider->toArray())
            );
        } catch (Throwable $e) {
            throw ChatBotClientException::from($e);
        }

        if ($response->isError()) {
            throw new ChatBotClientException($response->getError());
        }

        return $response;
        
    }
}