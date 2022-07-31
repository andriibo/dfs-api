<?php

namespace App\Notifications;

class SendEmailWelcomeNotification extends AbstractEmailTemplateNotification
{
    protected string $templateName = 'welcomeNewUser';

    public function __construct(private readonly ?string $username)
    {
        parent::__construct();
    }

    protected function getPlaceholders(): array
    {
        $frontUrl = config('app.front_url');

        return [
            '{username}' => $this->username,
            '{site_name}' => config('app.name'),
            '{how_to_play_link}' => "{$frontUrl}/static/how_to_play",
            '{rules_link}' => "{$frontUrl}/static/rules",
            '{faq_link}' => "{$frontUrl}/static/faq",
            '{privacy_link}' => "{$frontUrl}/static/privacy",
        ];
    }
}
