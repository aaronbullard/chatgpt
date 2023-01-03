<?php

namespace App\OpenAI;

use App\OpenAI\PromptProviders\Answer;
use App\OpenAI\PromptProviders\Question;
use RuntimeException;

class ClientIntelligenceService extends IntelligenceService
{
    public function __construct(private OpenAIGateway $client){}

    public function ask(Question $question): Answer
    {
        if (!isset($this->promptProvider)) {
            throw new RuntimeException("No prompt provider has been set.");
        }

        return $this->promptProvider->execute($this->client, $question);
    }
}