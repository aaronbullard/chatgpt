<?php

namespace App\OpenAI\Exceptions;

use App\Exceptions\DomainException;
use stdClass;

class ChatBotClientException extends DomainException
{
    protected stdClass $response;

    public function setResponse(stdClass $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse(): stdClass
    {
        return $this->response;
    }
}