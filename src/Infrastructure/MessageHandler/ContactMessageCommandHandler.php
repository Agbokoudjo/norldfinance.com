<?php
namespace App\Infrastructure\MessageHandler;

use Symfony\Component\Messenger\MessageBusInterface;
use App\Application\UseCase\Command\ContactMessageCommand;
use App\Application\UseCase\Command\SendContactEmailCommand;
use App\Application\UseCase\CommandHandler\ContactMessagePersistCommandHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler(fromTransport: 'async',handles: ContactMessageCommand::class)]
final class ContactMessageCommandHandler
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private ContactMessagePersistCommandHandler $persistHandler
    ) {}

    public function __invoke(ContactMessageCommand $data): void
    {
        $this->persistHandler->hander($data);
        // Dispatch du message d'envoi de notification à l'admin
        $new_envelope= (new Envelope(new SendContactEmailCommand($data)));
       $this->messageBus->dispatch($new_envelope->with(new DispatchAfterCurrentBusStamp()));
    }
}
