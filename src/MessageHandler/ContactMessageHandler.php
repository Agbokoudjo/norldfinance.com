<?php
 namespace App\MessageHandler;

use DateTimeImmutable;
use App\Message\ContactMessage;
use App\Domain\Contact\ContactFormRequest;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Domain\Contact\ContactFormRepositoryInterface;
use App\Message\SendContactNotificationMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
#[AsMessageHandler]
final class ContactMessageHandler
{
    public function __construct(
        private readonly ContactFormRepositoryInterface $contactFormModel,
        private readonly MessageBusInterface $messageBus
    ) {}

    public function __invoke(ContactMessage $message): void
    {
        $contactData=new ContactFormRequest();
        $contactData->setFullname($message->getName())
                    ->setEmail($message->getEmail())
                    ->setPhone($message->getPhone())
                    ->setIp($message->getIp())
                    ->setSubject($message->getSubject())
                    ->setContent($message->getContent())
                    ->setCreatedAt(new DateTimeImmutable())
                    ;
        $this->contactFormModel->add($contactData,true);
        // Dispatch du message d'envoi de notification à l'admin
       $this->messageBus->dispatch(new SendContactNotificationMessage(
            $message->getName(),
            $message->getEmail(),
            $message->getPhone(),
            $message->getSubject(),
            $message->getContent()
        ));
    }
}
