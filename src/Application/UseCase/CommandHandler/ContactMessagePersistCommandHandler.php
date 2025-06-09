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

namespace App\Application\UseCase\CommandHandler;
use DateTimeImmutable;
use App\Domain\Contact\ContactFormRequest;
use App\Domain\Contact\ContactFormRepositoryInterface;
use App\Application\UseCase\Command\ContactMessageCommand;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
final class ContactMessagePersistCommandHandler{
    public function __construct(private readonly ContactFormRepositoryInterface $managerRegistryContact)
    {
        
    }
    public function hander(ContactMessageCommand $contactData):void
    {
        $contactDataRequest = new ContactFormRequest();
        $contactDataRequest->setFullname($contactData->name)
            ->setEmail($contactData->email)
            ->setPhone($contactData->phone)
            ->setIp($contactData->ip)
            ->setSubject($contactData->subject)
            ->setContent($contactData->content)
            ->setCreatedAt(new DateTimeImmutable())
        ;
        $this->managerRegistryContact->add($contactDataRequest,true);
    }
}