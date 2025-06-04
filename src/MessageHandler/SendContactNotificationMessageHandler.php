<?php

namespace App\MessageHandler;

use App\Message\SendContactNotificationMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsMessageHandler]
final class SendContactNotificationMessageHandler
{

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly ParameterBagInterface $services,
        private readonly Environment $twig
    ) {}

    public function __invoke(SendContactNotificationMessage $message): void
    {
        $htmlContent = $this->twig->render('emails/contact_notification.html.twig', [
            'fullname' => $message->fullname,
            'email' => $message->email,
            'subject' => $message->subject,
            'content' => $message->content,
            'phone' => $message->phone,
            'organization_name' => $this->services->get('NAME_SITE'), // ou injecter dynamiquement
        ]);

        $email = (new Email())
            ->from($message->email)
            ->to($this->services->get('email.admin'))
            ->subject('Nouveau message de contact : ' . $message->subject)
            ->html($htmlContent);
        $this->mailer->send($email);
    }
}
