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

    public function __invoke(SendContactEmailCommand $message): void
    {
        $contact_data=$message->getContactData();
        $this->servicesMailer->send(
            $contact_data->email,
            $this->services->get('email.admin'),
            $contact_data->subject,
            'contact/contact_notification.html.twig',
            [
                'fullname' => $contact_data->name,
                'contact_sender_email' =>  $contact_data->email,
                'subject' =>  $contact_data->subject,
                'content' =>  $contact_data->content,
                'phone' =>  sprintf('%s %s', $contact_data->phone->getCountryCode(), $contact_data->phone->getNationalNumber()),
                'organization_name' => $this->services->get('NAME_SITE'),
                'locale' => 'fr'
            ]
        );
    }
}
