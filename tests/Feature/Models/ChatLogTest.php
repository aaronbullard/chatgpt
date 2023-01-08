<?php

namespace Tests\Feature\Models;

use Tests\Feature\TestCase;
use App\Models\ChatLog;
use App\OpenAI\ChatBot\ChatBotResponse;

class ChatLogTest extends TestCase
{
    public function test_log_method()
    {
        $id = (new ChatLog)->log(
            42,
            'BusinessDescriptionPromptProvider',
            new ChatBotResponse([
                'model' => 'text-davinci-003',
                'usage' => [
                    'total_tokens' => 4,
                    'prompt_tokens' => 2,
                    'completion_tokens' => 2
                ]
            ])
        );

        $this->assertDatabaseHas('chat_logs', [
            'id' => $id,
            'prompt_provider' => 'BusinessDescriptionPromptProvider',
            'is_error' => false,
            'usage_total_tokens' => 4
        ]);
    }
}