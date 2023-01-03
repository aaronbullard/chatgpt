<?php

namespace App\OpenAI\PromptProviders;

use App\Exceptions\DomainException;
use App\OpenAI\Exceptions\InvalidRequestError;
use App\OpenAI\OpenAIGateway;

class BusinessDescriptionPromptProvider extends PromptProvider
{
    const USE_CASE = 'business-description';

    public function execute(OpenAIGateway $client, Question $question): Answer
    {
        $response = $client->completion([
            'model' => 'text-davinci-003',
            'prompt' => 'Make the following description better and more professional' . $question->getRequest(),
            'temperature' => 0.9,
            'max_tokens' => 500,
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
            'user' => $question->getBusinessId()
        ]);

        if (isset($response->error)) {
            switch($response->error->type) {
                case 'invalid_request_error': 
                    throw new InvalidRequestError($response->error->message);
                break;
                default:
                    throw new DomainException($response->error->message);
            }
        }

        try {
            // Refactor later
            return new Answer($response->choices[0]->text, new Meta($response));
        } catch (\Throwable $e) {
            throw new InvalidRequestError($e->getMessage(), $e->getCode(), $e);
        }
        
    }
}