<?php

namespace App\OpenAI\ChatBot;

use Throwable;
use stdClass;
use App\OpenAI\Exceptions\ChatBotClientException;
use Orhanerday\OpenAi\OpenAi;

class OpenAIGateway extends OpenAi
{
    public function completion($opts, $stream = null): stdClass
    {
        try {
            return $this->decode(parent::completion($opts, $stream));
        } catch (Throwable $e) {
            throw ChatBotClientException::from($e);
        }
    }

    private function decode(string $response): stdClass
    {
        return json_decode($response);
    }
}