<?php

namespace Database\Factories;

use App\Models\ChatLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatLog>
 */
class ChatLogFactory extends Factory
{
    private string $response = '{"id":"cmpl-6USgjcAQZAnm12TVQ8HFyvP19nX2o","object":"text_completion","created":1672718137,"model":"text-davinci-003","choices":[{"text":"2 + 2 = 4","index":0,"logprobs":null,"finish_reason":"stop"}],"usage":{"prompt_tokens":6,"completion_tokens":7,"total_tokens":13}}';

    private string $error = '{"error": {"message": "42 is not of type string", "type": "invalid_request_error", "param": null, "code": null}}';

    protected $model = ChatLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $response = json_decode($this->response, true);
        $promptTokens = fake()->randomNumber(2, false);
        $completionTokens = fake()->randomNumber(2, false);

        $response['usage'] = [
            'prompt_tokens' => $promptTokens,
            'completion_tokens' => $completionTokens,
            'total_tokens' => $promptTokens + $completionTokens
        ];

        return [
            'profile_id' => fake()->randomNumber(5, true),
            'prompt_provider' => 'BusinessDescriptionPromptProvider',
            'response' => $response,
            'is_error' => false,
            'usage_total_tokens' => $promptTokens + $completionTokens
        ];
    }

    public function isError()
    {
        return $this->state(function (array $attributes) {
            return [
                'response' => json_decode($this->error, true),
                'is_error' => true
            ];
        });
    }
}
