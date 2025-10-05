<?php

declare(strict_types=1);

namespace App\Infrastructure\MessageHandler;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Application\UseCase\Command\ContactFormCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Application\UseCase\Command\SendContactEmailCommand;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use App\Application\UseCase\CommandHandler\ContactFormPersistCommandHandler;

#[AsMessageHandler(fromTransport: 'async',handles: ContactFormCommand::class)]
final class ContactFormCommandHandler
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private ContactFormPersistCommandHandler $persistHandler
    ) {}

    public function __invoke(ContactFormCommand $data): void
    {
        $this->persistHandler->hander($data);
        // Dispatch du message d'envoi de notification à l'admin
        $new_envelope= (new Envelope(new SendContactEmailCommand($data)));
       $this->messageBus->dispatch($new_envelope->with(new DispatchAfterCurrentBusStamp()));
    }
}
