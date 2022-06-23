<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class UserBalanceUpdatedEvent
{
    use Dispatchable;

    public function __construct(public readonly int $userId)
    {
    }
}
