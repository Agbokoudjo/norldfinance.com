<?php
declare(strict_types=1);

namespace App\Domain\Contact;

use libphonenumber\PhoneNumber;

interface ContactFormInterface
{
    public function setFullname(string $fullname): self;
    public function setEmail(string $email): self;
    public function setPhone(?PhoneNumber $phone): self;
    public function setSubject(string $subject): self;
    public function setContent(string $content): self;

    public function getFullname(): string;
    public function getEmail(): string;
    public function getPhone(): ?PhoneNumber;
    public function getSubject(): string;
    public function getContent(): string;
    public function getId(): int|string|null;
}
