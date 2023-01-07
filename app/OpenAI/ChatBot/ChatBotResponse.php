<?php

namespace App\OpenAI\ChatBot;

use Closure;
use Throwable;
use App\OpenAI\Exceptions\ChatBotResponseException;

class ChatBotResponse
{
    private array $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function isError(): bool
    {
        return isset($this->response['error']);
    }

    public function getError(): string
    {
        return $this->response['error']['message'];
    }

    public function getBody(): array
    {
        return $this->response;
    }

    private function safely(Closure $fn)
    {
        try {
            return $fn($this->response);
        } catch (Throwable $e) {
            throw ChatBotResponseException::from($e);
        }
    }

    public function getId(): string
    {
        return $this->safely(function($response){
            return $response['id'];
        });
    }

    public function getDescription(): string
    {
        return $this->safely(function($response){
            return $response['choices'][0]['text'];
        });
    }

    public function getUsage(): Usage
    {
        return $this->safely(function($response){
            return new Usage(
                $response['usage']['prompt_tokens'],
                $response['usage']['completion_tokens']
            );
        });
    }
}