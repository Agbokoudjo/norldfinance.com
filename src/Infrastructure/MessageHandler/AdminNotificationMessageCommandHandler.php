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
        // Récupère l'adresse sécurisée (support@monetrafinance.com) et l'adresse du client
        $secureSenderAndRecipient = $this->params->get('email.admin');
        $clientEmail = $message->email;

        // Chemin vers le dossier public
        $uploadsDir = sprintf('%s/public/medias', $this->params->get('kernel.project_dir'));

        // Crée le nouvel objet e-mail
        $email = (new TemplatedEmail())
            // Règle de sécurité cruciale : Utilise l'adresse SMTP d'authentification (support@monetrafinance.com)
            ->from($secureSenderAndRecipient)

            // Définit le destinataire, qui est vous-même (support@monetrafinance.com)
            ->to($secureSenderAndRecipient)

            // Définit l'adresse de réponse pour que vous puissiez répondre au client directement.
            ->replyTo($clientEmail)

            // Définit l'objet de l'e-mail
            ->subject(sprintf('Nouvelle demande de prêt de %s %s', $message->lastname, $message->firstname))
            ->htmlTemplate('loanapplication/loan_request_notification.html.twig');

        // 🖼️ Embeds des images (code inchangé)
        $email->embedFromPath("{$uploadsDir}/images/identity/{$message->identityphotoname1}", 'photo1.jpg');
        // Correction de l'erreur potentielle : assurez-vous que la variable est correcte
        $email->embedFromPath("{$uploadsDir}/images/identity/{$message->identityphotoname2}", 'photo2.jpg');

        // 📎 Attache le document PDF (code inchangé)
        $email->attachFromPath("{$uploadsDir}/documents/identity/{$message->identitydocumentname}", 'document_identité.pdf');

        // 💡 Context Twig
        // Le contexte reste le même, il contient les données du client pour l'affichage
        $email->context([
            'lastname' => $message->lastname,
            'firstname' => $message->firstname,
            'request_sender_email' => $clientEmail, // L'e-mail du client est dans le contexte pour l'affichage
            'phone' => sprintf('%s %s', $message->phone->getCountryCode(), $message->phone->getNationalNumber()),
            'adresse' => $message->adresse,
            'country' => $message->country,
            'city' => $message->city,
            'montant' => $message->montant,
            'devise' => $message->devise,
            'duration' => $message->duration,
            'subject' => $message->subject,
            'consentcheckbox' => $message->consentcheckbox,
            'NAME_SITE' => $this->params->get('NAME_SITE'),
            // // Ajout des CID pour les images embeddées si le template en a besoin (souvent le cas)
            // 'photo1Cid' => $photo1Cid,
            // 'photo2Cid' => $photo2Cid,
        ]);

        // Envoi de l'e-mail
        $this->mailer->send($email);
    }
}
