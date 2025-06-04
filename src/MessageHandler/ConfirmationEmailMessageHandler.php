<?php
namespace App\MessageHandler;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use App\Message\ConfirmationEmailMessage;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsMessageHandler]
class ConfirmationEmailMessageHandler
{
    public function __construct(
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator,
        private Environment $twig,
    ) {}

    public function __invoke(ConfirmationEmailMessage $message)
    {
        // Génère l’URL complète avec token
        $url = $this->urlGenerator->generate('rrr', [
            'token' => $message->getToken(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
        // Rendu HTML de l’e-mail avec Twig
        $htmlContent = $this->twig->render('emails/confirmation_email.html.twig', [
            'fullName' => $message->getFullName(),
            'confirmationUrl' => $url,
        ]);
        $email = (new Email())
            ->from('fff')
            ->to($message->getEmail())
            ->subject('Confirmez votre adresse e-mail')
            ->html($htmlContent);
        $this->mailer->send($email);
    }
}
