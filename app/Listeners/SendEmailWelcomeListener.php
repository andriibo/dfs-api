<?php

namespace App\Listeners;

use App\Events\UserActivatedEvent;
use App\Events\UserOAuthActivatedEvent;

class SendEmailWelcomeListener
{
    public function handle(UserActivatedEvent|UserOAuthActivatedEvent $event): void
    {
        $event->user->sendEmailWelcomeNotification();
    }
}
