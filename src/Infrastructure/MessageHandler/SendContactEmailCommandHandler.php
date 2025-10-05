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

use App\Application\Mailer\ServicesMailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Application\UseCase\Command\SendContactEmailCommand;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
#[AsMessageHandler(fromTransport: 'async',handles: SendContactEmailCommand::class)]
final class SendContactEmailCommandHandler
{

    public function __construct(
        private readonly ParameterBagInterface $services,
        private ServicesMailerInterface $servicesMailer
    ) {}

    // Fichier : Votre_Gestionnaire.php (où se trouve la méthode __invoke)

    public function __invoke(SendContactEmailCommand $message): void
    {
        $contact_data = $message->getContactFormData();

        // 1. Récupération de l'adresse d'envoi sécurisée (votre adresse SMTP/From)
        // C'est votre adresse support@monetrafinance.com (votre authentification)
        // J'utilise ici un service/paramètre appelé 'email.sender' (à adapter si nécessaire)
        $senderEmail = $this->services->get('email.sender');

        // 2. Récupération de l'adresse de destination (votre boîte de réception admin)
        // Votre adresse support@monetrafinance.com est souvent la même
        $adminRecipientEmail = $this->services->get('email.admin');

        // 3. Appel à la méthode send() avec les arguments dans le bon ordre
        $this->servicesMailer->send(
            // ARGUMENT 1 : $senderEmail (adresse From sécurisée)
            $senderEmail,

            // ARGUMENT 2 : $recipientEmail (votre boîte de réception)
            $adminRecipientEmail,

            // ARGUMENT 3 : $subject
            $contact_data->subject,

            // ARGUMENT 4 : $htmlTemplate
            'contact/contact_notification.html.twig',

            // ARGUMENT 5 : $context (tableau de données pour le template)
            [
                'fullname' => $contact_data->name,
                'contact_sender_email' =>  $contact_data->email, // L'e-mail du client reste dans le template
                'subject' =>  $contact_data->subject,
                'content' =>  $contact_data->content,
                'phone' =>  sprintf('%s %s', $contact_data->phone->getCountryCode(), $contact_data->phone->getNationalNumber()),
                'organization_name' => $this->services->get('NAME_SITE'),
                'locale' => 'fr'
            ],

            // ARGUMENT 6 : $replyToEmail (NOUVEAU - l'e-mail du client pour la réponse)
            $contact_data->email
        );
    }
}
