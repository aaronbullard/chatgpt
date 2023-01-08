<?php

use Tests\TestCase;
use App\Models\ChatLog;
use App\OpenAI\ChatBot\ChatBotResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_chat_log_instance()
    {
        $chatLog = ChatLog::log(
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
            'id' => $chatLog->id,
            'prompt_provider' => 'BusinessDescriptionPromptProvider',
            'is_error' => false,
            'usage_total_tokens' => 4
        ]);
    }
}