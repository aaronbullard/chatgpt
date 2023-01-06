<?php

namespace App\Providers;

use Mockery;
use App\OpenAI\ChatBot\ChatBot;
use App\OpenAI\ChatBot\ClientChatBot;
use App\OpenAI\Gateways\OpenAIGateway;
use App\OpenAI\ChatBot\UsageLimitChatBot;
use App\OpenAI\ChatBot\UsageLoggerChatBot;
use App\OpenAI\Contracts\Logger;
use App\OpenAI\Contracts\UsageChecker;
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

        $this->app->bind(Logger::class, function(){
            $logger = Mockery::mock(Logger::class);
            $logger->shouldReceive('log')->andReturn(null);
            return $logger;
        });

        $this->app->bind(UsageChecker::class, function(){
            $checker = Mockery::mock(UsageChecker::class);
            $checker->shouldReceive('usageAvailable')->andReturn(true);
            $checker->shouldReceive('recordUsage')->andReturn($checker);
            return $checker;
        });

        $this->app->bind(ChatBot::class, function($app){
            $bot = new ClientChatBot($app->make(OpenAIGateway::class));
            $bot = new UsageLoggerChatBot($bot, $app->make(Logger::class));
            $bot = new UsageLimitChatBot($bot, $app->make(UsageChecker::class));

            return $bot;
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
