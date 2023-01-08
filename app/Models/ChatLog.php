<?php

namespace App\Models;

use App\OpenAI\ChatBot\ChatBotResponse;
use App\Exceptions\ChatLogException;
use App\OpenAI\Contracts\Logger;
use App\OpenAI\Exceptions\ChatBotResponseException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatLog extends Model implements Logger
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'response' => 'array',
    ];

    /** @inheritDoc */
    public function log(
        int $profileId, 
        string $promptProvider, 
        ChatBotResponse $response
    ): int
    {
        try {
            $chatLog = static::create([
                'profile_id' => $profileId,
                'prompt_provider' => $promptProvider,
                'response' => $response->getBody(),
                'is_error' => $response->isError(),
                'usage_total_tokens' => $response->getUsage()->totalTokens()
            ]);

            return $chatLog->id;
        } catch (ChatBotResponseException $e) {
            throw ChatLogException::from($e);
        }
    }
}
