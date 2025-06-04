<?php
namespace App\Domain\Contact;

use libphonenumber\PhoneNumber;

trait ContactFormPropertyTrait{
    protected string $fullname;
    protected string $email;
    protected ?PhoneNumber $phone=null;
    protected string $subject;
    protected string $content;
}