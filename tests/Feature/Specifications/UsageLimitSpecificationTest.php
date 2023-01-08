<?php

namespace Tests\Feature\Specifications;

use Tests\Feature\TestCase;
use App\Models\ChatLog;
use App\Specifications\UsageLimitSpecification;

class UsageLimitSpecificationTest extends TestCase
{
    public function test_usage_available_method()
    {
        ChatLog::factory()->count(2)->create([
            'profile_id' => 1,
            'usage_total_tokens' => 501,
            'created_at' => new \DateTime('-2 days')
        ]);

        // executed within the last 24 hrs
        ChatLog::factory()->count(2)->create([
            'profile_id' => 2,
            'usage_total_tokens' => 501,
            'created_at' => new \DateTime()
        ]);

        $spec = $this->app->make(UsageLimitSpecification::class);

        $true = $spec->usageAvailable(1);
        $false = $spec->usageAvailable(2);

        $this->assertTrue($true);
        $this->assertFalse($false);
    }
}