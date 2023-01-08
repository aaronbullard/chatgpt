<?php

namespace Tests\Feature\OpenAI\Services;

use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use App\Shared\ErrorResponse;
use App\OpenAI\Contracts\Logger;
use App\OpenAI\Gateways\OpenAIGateway;
use App\OpenAI\Services\BusinessDescriptionRequest;
use App\OpenAI\Services\BusinessDescriptionResponse;
use App\OpenAI\Services\BusinessDescriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessDescriptionServiceTest extends TestCase
{
    use RefreshDatabase;

    private string $response = '{"id":"cmpl-6USgjcAQZAnm12TVQ8HFyvP19nX2o","object":"text_completion","created":1672718137,"model":"text-davinci-003","choices":[{"text":"2 + 2 = 4","index":0,"logprobs":null,"finish_reason":"stop"}],"usage":{"prompt_tokens":6,"completion_tokens":7,"total_tokens":13}}';

    private string $error = '{"error": {"message": "42 is not of type string", "type": "invalid_request_error", "param": null, "code": null}}';

    private $profileId = 42;

    private function mockCallback($response)
    {
        $this->instance(
            OpenAIGateway::class,
            Mockery::mock(OpenAIGateway::class, function(MockInterface $mock) use ($response){
                $mock->shouldReceive('completion')->once()->andReturn(json_decode($response, true));
            })
        );
    }

    public function test_successful_call(): BusinessDescriptionResponse
    {
        $this->mockCallback($this->response);
        
        $service = $this->app->make(BusinessDescriptionService::class);

        $description = "What is 2 + 2?";

        $response = $service->execute(
            new BusinessDescriptionRequest($this->profileId, $description)
        );

        $this->assertInstanceOf(BusinessDescriptionResponse::class, $response);
        $this->assertEquals($response->getDescription(), "2 + 2 = 4");

        return $response;
    }

    public function test_failed_call()
    {
        $this->mockCallback($this->error);

        $service = $this->app->make(BusinessDescriptionService::class);

        $description = "What is 2 + 2?";

        $response = $service->execute(
            new BusinessDescriptionRequest($this->profileId, $description)
        );

        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->assertEquals($response->getError(), '42 is not of type string');
    }

    public function test_usage_logger_chat_bot()
    {
        $response = $this->test_successful_call();

        $this->assertDatabaseHas('chat_logs', [
            'profile_id' => $this->profileId,
            'usage_total_tokens' => $response->getBody()['usage']['total_tokens']
        ]);
    }
}