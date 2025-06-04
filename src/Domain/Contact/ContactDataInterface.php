<?php
namespace App\Domain\Contact;

interface ContactDataInterface
{
    public function setFullname(string $fullname): static;
    public function setEmail(string $email): static;
    public function setPhone(string $phone): static;
    public function setSubject(string $subject): static;
    public function setContent(string $content): static;

    public function getFullname(): string;
    public function getEmail(): string;
    public function getPhone(): string;
    public function getSubject(): string;
    public function getContent(): string;
    public function getId(): int|string;
}
