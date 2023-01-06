<?php

namespace App\OpenAI\PromptProviders;

class BusinessDescriptionPromptProvider implements PromptProvider
{
    public function __construct(
        private int $profileId, 
        private string $description
    ){}

    public function getProfileId(): int
    {
        return $this->profileId;
    }

    public function toArray(): array
    {
        return [
            'model' => 'text-davinci-003',
            'prompt' => 'Make the following description better and more professional:' . $this->description,
            'temperature' => 0.9,
            'max_tokens' => 500,
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
            'user' => (string) $this->profileId
        ];
    }
}