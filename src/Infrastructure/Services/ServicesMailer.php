<?php

declare(strict_types=1);
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

namespace App\Infrastructure\Services;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Application\Mailer\ServicesMailerInterface;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
final class ServicesMailer implements ServicesMailerInterface
{
    public function __construct(private MailerInterface $mailer) {}

    /**
     * Envoie un e-mail avec un template Twig.
     *
     * @param string $senderEmail L'adresse e-mail qui sera utilisée dans le champ 'From' (Doit correspondre à l'adresse SMTP d'authentification).
     * @param string $recipientEmail L'adresse e-mail du destinataire (ex: email.admin).
     * @param string $subject L'objet de l'e-mail.
     * @param string $htmlTemplate Le chemin vers le template Twig (ex: 'contact/contact_notification.html.twig').
     * @param array $context Tableau des variables à passer au template Twig.
     * @param ?string $replyToEmail L'adresse à laquelle l'utilisateur répondra (ex: l'e-mail du client).
     */
    public function send(
        string $senderEmail,    // L'adresse 'From' sécurisée (celle du MAILER_DSN : support@monetrafinance.com)
        string $recipientEmail, // L'adresse 'To' du destinataire (l'administrateur)
        string $subject,
        string $htmlTemplate,
        ?array $context = null,
        ?string $replyToEmail = null // Nouvelle variable optionnelle pour l'adresse du client
    ): void {
        // Crée un nouvel objet e-mail basé sur un template Twig
        $email = new TemplatedEmail();

        // Définit l'expéditeur de l'e-mail. C'EST LA LIGNE CLÉ pour la sécurité SMTP.
        // Cette adresse DOIT correspondre à l'utilisateur du MAILER_DSN pour éviter l'erreur 553.
        $email->from($senderEmail)
            // Définit le destinataire de l'e-mail (votre boîte de réception admin)
            ->to($recipientEmail)
            // Définit l'objet de l'e-mail
            ->subject($subject)
            // Associe le template HTML Twig à utiliser
            ->htmlTemplate($htmlTemplate);

        // Ajout conditionnel de l'adresse de réponse
        if ($replyToEmail) {
            // Définit l'adresse à laquelle la réponse sera envoyée (Reply-To).
            // C'est ici que l'on met l'adresse du client (ex: franckagbokoudjo301@gmail.com).
            $email->replyTo($replyToEmail);
        } else {
            // Si aucune adresse Reply-To spécifique n'est fournie,
            // la réponse ira par défaut à l'expéditeur (senderEmail)
            $email->replyTo($senderEmail);
        }

        // Si des variables de contexte sont fournies, les ajoute à l'e-mail (pour le template Twig)
        if ($context) {
            $email->context($context);
        }

        // Envoie l'e-mail via l'interface Mailer
        $this->mailer->send($email);
    }
}
