<?php
/*
 * This file is part of the project by AGBOKOUDJO Franck.
 *
 * (c) AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * Phone: +229 0167 25 18 86
 * LinkedIn: https://www.linkedin.com/in/internationales-web-services-120520193/
 * Github: https://github.com/Agbokoudjo/norldfinance.com
 * Company: INTERNATIONALES WEB SERVICES
 *
 * For more information, please feel free to contact the author.
 */

namespace App\Infrastructure\MessageHandler;

use App\Application\UseCase\Command\AdminNotificationMessageCommand;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
#[AsMessageHandler(fromTransport: 'async',handles: AdminNotificationMessageCommand::class)]
final class AdminNotificationMessageCommandHandler
{
    public function __construct(
        private readonly ParameterBagInterface $params,
        private MailerInterface $mailer
    ) {}

    public function __invoke(AdminNotificationMessageCommand $message): void
    {
        $uploadsDir = sprintf('%s/public/medias', $this->params->get('kernel.project_dir')); // chemin vers le dossier public

        $email = (new TemplatedEmail())
            ->from($message->email)
            ->to($this->params->get('email.admin'))
            ->subject(sprintf('Nouvelle demande de prêt de %s %s', $message->lastname, $message->firstname))
            ->htmlTemplate('loanapplication/loan_request_notification.html.twig');

        // 🖼️ Embeds des images
        $photo1Cid = $email->embedFromPath("{$uploadsDir}/images/identity/{$message->identityphotoname1}", 'photo1.jpg');
        $photo2Cid = $email->embedFromPath("{$uploadsDir}/images/identity/{$message->identityphotoname2}", 'photo2.jpg'); // ⚠️ correction: identityphotoname2

        // 📎 Attache le document PDF
        $email->attachFromPath("{$uploadsDir}/documents/identity/{$message->identitydocumentname}", 'document_identité.pdf');

        // 💡 Context Twig
        $email->context([
            'lastname' => $message->lastname,
            'firstname' => $message->firstname,
            'request_sender_email' => $message->email,
            'phone' => sprintf('%s %s', $message->phone->getCountryCode(), $message->phone->getNationalNumber()),
            'adresse' => $message->adresse,
            'country' => $message->country,
            'city' => $message->city,
            'montant' => $message->montant,
            'devise' => $message->devise,
            'duration' => $message->duration,
            'subject'=>$message->subject,
            'consentcheckbox' => $message->consentcheckbox,
            'NAME_SITE'=> $this->params->get('NAME_SITE')
        ]);
        $this->mailer->send($email);
    }
}
