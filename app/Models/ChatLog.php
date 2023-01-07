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
                'usage_prompt_tokens' => $response->getUsage()->promptTokens(),
                'usage_completion_tokens' => $response->getUsage()->completionTokens()
            ]);
        } catch (ChatBotResponseException $e) {
            throw ChatLogException::from($e);
        }
    }

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function usage(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => new Usage(
                $attributes['usage_prompt_tokens'],
                $attributes['usage_completion_tokens']
            ),
            set: fn (Usage $usage) => [
                'usage_prompt_tokens' => $usage->promptTokens(),
                'usage_completion_tokens' => $usage->completionTokens()
            ],
        );
    }
}
