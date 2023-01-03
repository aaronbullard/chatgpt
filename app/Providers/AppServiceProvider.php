<?php

namespace App\Providers;

use App\OpenAI\ClientIntelligenceService;
use App\OpenAI\IntelligenceService;
use App\OpenAI\IntelligenceServiceFactory;
use App\OpenAI\OpenAIGateway;
use App\OpenAI\PromptProviders\BusinessDescriptionPromptProvider;
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

        $this->app->bind(IntelligenceService::class, function($app){
            return new ClientIntelligenceService($app->make(OpenAIGateway::class));
        });

        $this->app->bind(IntelligenceServiceFactory::class, function($app){
            return new IntelligenceServiceFactory(
                $app->make(IntelligenceService::class),
                new BusinessDescriptionPromptProvider()
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
