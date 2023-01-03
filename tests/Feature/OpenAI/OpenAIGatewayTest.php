<?php

namespace Tests\Feature\OpenAI;

use App\OpenAI\IntelligenceServiceFactory;
use App\OpenAI\OpenAIGateway;
use App\OpenAI\PromptProviders\Question;
use Tests\TestCase;

class OpenAIGatewayTest extends TestCase
{
    private function test_it_connects()
    {
        $client = $this->app->make(OpenAIGateway::class);

        $response = $client->completion([
            'model' => 'text-davinci-003',
            'prompt' => 'What is 2 + 2?',
            'temperature' => 0.9,
            'max_tokens' => 150,
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
        ]);

        dd($response);
    }

    public function test_real_api()
    {
        $factory = $this->app->make(IntelligenceServiceFactory::class);

        $answer = $factory->createFor('business-description')->ask(
            new Question(42, "My business is the best.  Come vizit us at Wilmingtno NC.")
        );

        dd($answer);
    }
}