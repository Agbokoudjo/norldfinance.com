<?php

namespace App\Message;

use libphonenumber\PhoneNumber;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final class SendContactNotificationMessage
{
    public function __construct(
        public readonly string $fullname,
        public readonly string $email,
        public readonly string $subject,
        public readonly string $content,
        public readonly ?PhoneNumber $phone = null,
    ) {}
}
