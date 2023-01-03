<?php

namespace App\OpenAI;

use App\OpenAI\PromptProviders\Answer;
use App\OpenAI\PromptProviders\PromptProvider;
use App\OpenAI\PromptProviders\Question;

abstract class IntelligenceService
{
    protected PromptProvider $promptProvider;

    public function setPrompt(PromptProvider $promptProvider): self
    {
        $this->promptProvider = $promptProvider;

        return $this;
    }

    abstract public function ask(Question $question): Answer;
}