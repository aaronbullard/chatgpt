<?php

namespace App\OpenAI\Contracts;

interface UsageChecker
{
    /**
     * Checks if user can still make calls against ChatGPT.
     *
     * @param integer $profileId
     * @return boolean
     */
    public function usageAvailable(int $profileId): bool;
}