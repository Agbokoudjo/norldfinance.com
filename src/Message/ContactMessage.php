<?php
namespace App\Message;

use libphonenumber\PhoneNumber;

class ContactMessage
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $subject,
        private readonly string $message,
        private readonly string $ip,
        private readonly ?PhoneNumber $phone=null
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getContent(): string
    {
        return $this->message;
    }

    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }
    public function getIp(): string
    {
        return $this->ip;
    }
}
