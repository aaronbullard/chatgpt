<?php

namespace App\OpenAI\Contracts;

interface UsageChecker
{
    public function usageAvailable(int $profileId): bool;
}