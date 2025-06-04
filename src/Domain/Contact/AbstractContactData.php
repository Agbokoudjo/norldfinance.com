<?php

namespace App\Domain\Contact;

use App\Domain\SharedModel\CreatedAt;
use App\Domain\Contact\ContactDataInterface;

abstract class AbstractContactData implements ContactDataInterface
{
    use CreatedAt;
    use ContactFormPropertyTrait ;
    protected ?int $id;
    public function getId(): int
    {
        return $this->id;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setFullname(string $fullname): static
    {
        $this->fullname = $fullname;
        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }
}
