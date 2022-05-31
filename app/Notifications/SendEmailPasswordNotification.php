<?php

namespace App\Notifications;

class SendEmailPasswordNotification extends AbstractEmailTemplateNotification
{
    protected string $templateName = 'activateAccountFromOauth';

    public function __construct(private readonly string $email, private readonly string $password)
    {
        parent::__construct();
    }

    protected function getPlaceholders(): array
    {
        return [
            '{email}' => $this->email,
            '{password}' => $this->password,
        ];
    }
}
