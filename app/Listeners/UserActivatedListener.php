<?php

namespace App\Listeners;

use App\Events\UserActivatedEvent;
use App\Events\UserOAuthActivatedEvent;
use App\Services\Transactions\CreateActivationBonusDepositService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserActivatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(private readonly CreateActivationBonusDepositService $activationBonusDepositService)
    {
    }

    public function handle(UserActivatedEvent|UserOAuthActivatedEvent $event): void
    {
        $this->activationBonusDepositService->handle($event->user->id);
    }
}
