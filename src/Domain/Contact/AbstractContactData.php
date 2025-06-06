<?php

namespace App\Domain\Contact;

use App\Domain\SharedModel\CreatedAt;

use libphonenumber\PhoneNumber;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractContactData 
{
    use CreatedAt;
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'integer')]
    protected ?int $id = null;

    #[ORM\Column(type: 'string', length: 200)]
    protected string $fullname;

    #[ORM\Column(type: 'string', length: 180)]
    protected string $email;

    #[ORM\Column(type: 'phone_number', nullable: true)]
    protected ?PhoneNumber $phone = null;

    #[ORM\Column(type: 'string', length: 255)]
    protected string $subject;

    #[ORM\Column(type: 'text')]
    protected string $content;
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

    public function getPhone(): ?PhoneNumber
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

    public function setPhone(?PhoneNumber $phone=null): static
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
