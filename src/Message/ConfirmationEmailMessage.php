<?php
namespace App\Message;

class ConfirmationEmailMessage
{
    public function __construct(
        private string $email,
        private string $fullName,
        private string $token
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getFullName(): string
    {
        return $this->fullName;
    }
    public function getToken(): string
    {
        return $this->token;
    }
}
