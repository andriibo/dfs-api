<?php

namespace App\Listeners;

use App\Events\UserActivatedEvent;

class SendEmailWelcomeListener
{
    public function handle(UserActivatedEvent $event): void
    {
        $event->user->sendEmailWelcomeNotification();
    }
}
