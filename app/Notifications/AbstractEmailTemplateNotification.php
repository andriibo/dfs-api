<?php

namespace App\Notifications;

use App\Repositories\EmailTemplateRepository;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

abstract class AbstractEmailTemplateNotification
{
    protected string $templateName;

    private readonly EmailTemplateRepository $emailTemplateRepository;

    public function __construct()
    {
        $this->emailTemplateRepository = new EmailTemplateRepository();
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $emailTemplate = $this->emailTemplateRepository->getTeamplateByName($this->templateName);
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

    abstract protected function getPlaceholders(): array;
}
