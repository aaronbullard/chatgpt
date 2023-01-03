<?php

namespace Tests\Feature\OpenAI;

use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use App\OpenAI\ChatBot\OpenAIGateway;
use App\OpenAI\Exceptions\ChatBotClientException;
use App\OpenAI\Services\BusinessDescriptionRequest;
use App\OpenAI\Services\BusinessDescriptionResponse;
use App\OpenAI\Services\BusinessDescriptionService;

class IntelligenceServiceFactoryTest extends TestCase
{
    private BusinessDescriptionService $service;

    private string $response = '{"id":"cmpl-6USgjcAQZAnm12TVQ8HFyvP19nX2o","object":"text_completion","created":1672718137,"model":"text-davinci-003","choices":[{"text":"\n\n2 + 2 = 4","index":0,"logprobs":null,"finish_reason":"stop"}],"usage":{"prompt_tokens":6,"completion_tokens":7,"total_tokens":13}}';

    private string $error = '{"error": {"message": "42 is not of type string", "type": "invalid_request_error", "param": null, "code": null}}';

    public function setUp(): void
    {
        parent::setUp();
        
    }

    private function mockCallback(string $response)
    {
        $this->instance(
            OpenAIGateway::class,
            Mockery::mock(OpenAIGateway::class, function(MockInterface $mock) use ($response){
                $mock->shouldReceive('completion')->once()->andReturn(json_decode($response));
            })
        );
    }

    public function test_successful_call()
    {
        $this->mockCallback($this->response);
        $this->service = $this->app->make(BusinessDescriptionService::class);

        $description = "What is 2 + 2?";

        $response = $this->service->execute(
            new BusinessDescriptionRequest(42, $description)
        );

        $this->assertInstanceOf(BusinessDescriptionResponse::class, $response);
        $this->assertEquals($response->description, $response->meta->choices[0]->text);
    }

    public function test_failed_call()
    {
        $this->mockCallback($this->error);
        $this->service = $this->app->make(BusinessDescriptionService::class);

        $description = "What is 2 + 2?";

        $this->expectException(ChatBotClientException::class);

        $response = $this->service->execute(
            new BusinessDescriptionRequest(42, $description)
        );
    }

    public function test_malformed_response()
    {
        $this->mockCallback('{"lang": "javas');
        $this->service = $this->app->make(BusinessDescriptionService::class);

        $description = "What is 2 + 2?";

        $this->expectException(ChatBotClientException::class);

        $response = $this->service->execute(
            new BusinessDescriptionRequest(42, $description)
        );
    }
}