<?php

namespace App\OpenAI\Services;

use Throwable;
use App\OpenAI\ChatBot\ChatBot;
use App\OpenAI\Exceptions\ChatBotClientException;
use App\OpenAI\PromptProviders\BusinessDescriptionPromptProvider;
use App\Shared\ErrorResponse;
use App\Shared\Response;

class BusinessDescriptionService
{
    public function __construct(private ChatBot $chatBot){}

    /**
     * Returns the OpenAI response with new business description
     *
     * @param BusinessDescriptionRequest $request
     * @throws ChatBotClientException
     * @return BusinessDescriptionResponse
     */
    public function execute(BusinessDescriptionRequest $request): Response
    {
        try {
            $prompt = new BusinessDescriptionPromptProvider(
                $request->businessId,
                $request->description
            );

            $response = $this->chatBot->execute('completion', $prompt);

            return new BusinessDescriptionResponse(
                $response->getDescription(),
                $response->getBody()
            );
        } catch (Throwable $e) {
            return ErrorResponse::from($e);
        }
    }
}