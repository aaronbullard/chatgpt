<?php

namespace App\Providers;

use App\OpenAI\ChatBot\ChatBot;
use App\OpenAI\ChatBot\ClientChatBot;
use App\OpenAI\ChatBot\RateLimitChatBot;
use App\OpenAI\ChatBot\OpenAIGateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OpenAIGateway::class, function(){
            return new OpenAIGateway(config('services.openai'));
        });

        $this->app->bind(ChatBot::class, function($app){
            return new RateLimitChatBot(
                new ClientChatBot($app->make(OpenAIGateway::class)),
                'limiter_TBD'
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
