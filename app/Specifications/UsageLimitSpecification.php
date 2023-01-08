<?php

namespace App\Specifications;

use DateTime;
use DateInterval;
use Illuminate\Database\DatabaseManager as Database;
use App\OpenAI\Contracts\UsageChecker;

class UsageLimitSpecification implements UsageChecker
{
    const TIME_FRAME = '1 day';
    const TOKEN_LIMIT = 1000;

    public function __construct(private Database $db){}

    /**
     * Checks to see if the user has exceeded the TOKEN_LIMIT
     * within the TIME_FRAME
     *
     * @param integer $profileId
     * @return boolean
     */
    public function usageAvailable(int $profileId): bool
    {
        $interval = DateInterval::createFromDateString(self::TIME_FRAME);

        $tokens = $this->db->table('chat_logs')
            ->where('profile_id', '=', $profileId)
            ->where('created_at', '<', (new DateTime)->sub($interval))
            ->sum('usage_total_tokens');

        return $tokens >= self::TOKEN_LIMIT;
    }
}