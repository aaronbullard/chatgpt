<?php

namespace App\OpenAI\Services;

use Throwable;
use App\OpenAI\ChatBot\ChatBot;
use App\OpenAI\ChatBot\Meta;
use App\OpenAI\Exceptions\ChatBotClientException;
use App\OpenAI\PromptProviders\BusinessDescriptionPromptProvider;

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
    public function execute(BusinessDescriptionRequest $request): BusinessDescriptionResponse
    {
        $prompt = new BusinessDescriptionPromptProvider(
            $request->businessId,
            $request->description
        );

        try {
            $response = $this->chatBot->execute('completion', $prompt);

            return new BusinessDescriptionResponse(
                $response->choices[0]->text,
                new Meta($response)
            );
        } catch (ChatBotClientException $e) {
            throw $e; 
        } catch (Throwable $e) {
            throw ChatBotClientException::from($e);
        }
    }
}