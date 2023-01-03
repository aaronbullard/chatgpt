<?php

namespace Tests\Feature\OpenAI;

use Mockery;
use Tests\TestCase;
use App\OpenAI\IntelligenceService;
use App\OpenAI\ClientIntelligenceService;
use App\OpenAI\IntelligenceServiceFactory;
use App\OpenAI\OpenAIGateway;
use App\OpenAI\PromptProviders\Answer;
use App\OpenAI\PromptProviders\Question;
use App\OpenAI\PromptProviders\BusinessDescriptionPromptProvider;

class IntelligenceServiceFactoryTest extends TestCase
{
    private $client;

    private IntelligenceService $intelService;

    private $factory;

    private string $response = '{"id":"cmpl-6USgjcAQZAnm12TVQ8HFyvP19nX2o","object":"text_completion","created":1672718137,"model":"text-davinci-003","choices":[{"text":"\n\n2 + 2 = 4","index":0,"logprobs":null,"finish_reason":"stop"}],"usage":{"prompt_tokens":6,"completion_tokens":7,"total_tokens":13}}';

    public function setUp(): void
    {
        $this->client = Mockery::mock(OpenAIGateway::class);

        $this->intelService = new ClientIntelligenceService($this->client);

        $this->factory = new IntelligenceServiceFactory(
            $this->intelService,
            new BusinessDescriptionPromptProvider()
        );
    }

    public function test_factory_to_answer()
    {
        $this->client->shouldReceive('completion')->andReturn(
            json_decode($this->response)
        );

        $service = $this->factory->createFor(BusinessDescriptionPromptProvider::USE_CASE);

        $answer = $service->ask(new Question(42, "What is 2 + 2?"));

        $this->assertInstanceOf(Answer::class, $answer);
        $this->assertTrue(str_contains($answer->getResponse(), '2 + 2 = 4'));
    }
}