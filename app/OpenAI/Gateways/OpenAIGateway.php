<?php

namespace App\OpenAI\Gateways;

use Orhanerday\OpenAi\OpenAi;

class OpenAIGateway extends OpenAi
{
    public function completion($opts, $stream = null): array
    {
        return $this->decode(parent::completion($opts, $stream));
    }

    private function decode(string $response): array
    {
        return json_decode($response, true);
    }
}