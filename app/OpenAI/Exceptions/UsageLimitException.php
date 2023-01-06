<?php

namespace App\OpenAI\Exceptions;

use App\Exceptions\DomainException;

class UsageLimitException extends DomainException
{
    const LIMIT_REACHED = 'You have used your limit of this feature';
}