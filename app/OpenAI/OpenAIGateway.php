<?php

namespace App\OpenAI;

use Orhanerday\OpenAi\OpenAi;
use stdClass;

class OpenAIGateway extends OpenAi
{
    public function completion($opts, $stream = null): stdClass
    {
        return $this->decode(parent::completion($opts, $stream));
    }

    private function decode(string $response): stdClass
    {
        return json_decode($response);
    }
}