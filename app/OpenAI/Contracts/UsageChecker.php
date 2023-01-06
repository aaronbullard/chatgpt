<?php

namespace App\OpenAI\Contracts;

use App\OpenAI\ChatBot\Usage;

interface UsageChecker
{
    public function recordUsage(int $profileId, Usage $usage): self;
    public function usageAvailable(int $profileId): bool;
}