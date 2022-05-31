<?php

namespace App\Listeners;

use App\Events\UserOAuthActivatedEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SendEmailPasswordListener
{
    public function handle(UserOAuthActivatedEvent $event): void
    {
        $password = Str::random(8);
        $event->user->password = Hash::make($password);
        if ($event->user->save()) {
            $event->user->sendEmailPasswordNotification($password);
        }
    }
}
