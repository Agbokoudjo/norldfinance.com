<?php

namespace App\MessageHandler;

use App\Message\AdminNotificationMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface; // CORRECTION
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsMessageHandler]
final class AdminNotificationMessageHandler
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly ParameterBagInterface $params
    ) {}

    public function __invoke(AdminNotificationMessage $message): void
    {
        $uploadsDir = sprintf('%s/medias', $this->params->get('kernel.project_dir')); // chemin vers le dossier public

        $email = (new TemplatedEmail())
            ->from($message->email)
            ->to($this->params->get('email.admin'))
            ->subject(sprintf('Nouvelle demande de prêt de %s %s', $message->lastname, $message->firstname))
            ->htmlTemplate('emails/loan_request_notification.html.twig');

        // 🖼️ Embeds des images
        $photo1Cid = $email->embedFromPath("{$uploadsDir}/images/identity/{$message->identityphotoname1}", 'photo1.jpg');
        $photo2Cid = $email->embedFromPath("{$uploadsDir}/images/identity/{$message->identityphotoname2}", 'photo2.jpg'); // ⚠️ correction: identityphotoname2

        // 📎 Attache le document PDF
        $email->attachFromPath("{$uploadsDir}/documents/identity/{$message->identitydocumentname}", 'document_identité.pdf');

        // 💡 Context Twig
        $email->context([
            'lastname' => $message->lastname,
            'firstname' => $message->firstname,
            'email' => $message->email,
            'phone' => $message->phone,
            'adresse' => $message->adresse,
            'country' => $message->country,
            'city' => $message->city,
            'montant' => $message->montant,
            'devise' => $message->devise,
            'duration' => $message->duration,
            'subject'=>$message->subject,
            'consentcheckbox' => $message->consentcheckbox,
            'photo1Cid' => $photo1Cid,
            'photo2Cid' => $photo2Cid
        ]);

        $this->mailer->send($email);
    }
}
