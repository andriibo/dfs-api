<?php

namespace App\Notifications;

use App\Repositories\EmailTemplateRepository;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendEmailWelcomeNotification extends Notification
{
    private const TEMPLATE_NAME = 'welcomeNewUser';

    private readonly EmailTemplateRepository $emailTemplateRepository;

    public function __construct(private readonly string $username)
    {
        $this->emailTemplateRepository = new EmailTemplateRepository();
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $emailTemplate = $this->emailTemplateRepository->getTeamplateByName(self::TEMPLATE_NAME);
        $placeholders = $this->getPlaceholders();

        $subject = strtr($emailTemplate->subject_en, $placeholders);
        $body = strtr($emailTemplate->body_en, $placeholders);

        return $this->buildMailMessage($subject, $body);
    }

    protected function buildMailMessage(string $subject, string $body): MailMessage
    {
        return (new MailMessage())
            ->markdown('emails.template')
            ->subject($subject)
            ->line(new HtmlString($body))
        ;
    }

    private function getPlaceholders(): array
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
