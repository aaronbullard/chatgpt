<?php

namespace App\OpenAI;

use App\OpenAI\IntelligenceService;
use App\OpenAI\PromptProviders\PromptProvider;
use Illuminate\Support\Collection;

class IntelligenceServiceFactory
{
    private IntelligenceService $intelService;

    private Collection $promptProviders;

    public function __construct(IntelligenceService $intelService, PromptProvider ...$promptProvider)
    {
        $this->intelService = $intelService;
        $this->promptProviders = new Collection([...$promptProvider]);
    }

    /**
     * Undocumented function
     *
     * @param string $useCase
     * @throws Illuminate\Support\ItemNotFoundException
     * @return IntelligenceService
     */
    public function createFor(string $useCase): IntelligenceService
    {
        $promptProvider = $this->promptProviders->firstOrFail(function($provider) use ($useCase){
            return $provider->supports($useCase);
        });

        return $this->intelService->setPrompt($promptProvider);
    }
}