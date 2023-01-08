<?php

namespace App\Models;

use App\OpenAI\ChatBot\Usage;
use App\OpenAI\ChatBot\ChatBotResponse;
use App\Exceptions\ChatLogException;
use App\OpenAI\Exceptions\ChatBotResponseException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatLog extends Model
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

    /**
     * Create and persist istance to chat log
     *
     * @param integer $profileId
     * @param string $promptProvider
     * @param ChatBotResponse $response
     * @throws ChatLogException
     * @return self
     */
    public static function log(
        int $profileId, 
        string $promptProvider, 
        ChatBotResponse $response
    ): self
    {
        try {
            return static::create([
                'profile_id' => $profileId,
                'prompt_provider' => $promptProvider,
                'response' => $response->getBody(),
                'is_error' => $response->isError(),
                'usage_total_tokens' => $response->getUsage()->totalTokens()
            ]);
        } catch (ChatBotResponseException $e) {
            throw ChatLogException::from($e);
        }
    }
}
