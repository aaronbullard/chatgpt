<?php

namespace App\OpenAI\PromptProviders;

use stdClass;

class Meta
{
    public function __construct(private stdClass $response){}

    public function __get($attribute)
    {
        return $this->response->$attribute;
    }
}