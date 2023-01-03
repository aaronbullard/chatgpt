<?php

namespace App\OpenAI\PromptProviders;

use App\OpenAI\OpenAIGateway;

abstract class PromptProvider
{
    CONST USE_CASE = NULL;

    public function supports(string $useCase): bool
    {
        return static::USE_CASE === $useCase;
    }

    abstract public function execute(OpenAIGateway $client, Question $question): Answer;
}