<?php
    declare(strict_types=1);

namespace App\Domain\Contact;

use Doctrine\ORM\Mapping as ORM;
use libphonenumber\PhoneNumber;
use App\Domain\SharedModel\CreatedAt;
use App\Domain\Contact\ContactFormInterface ;

#[ORM\Entity]
class ContactFormRequest implements ContactFormInterface{
    use CreatedAt;

      #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'integer')]
    protected ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $ip = '';

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


    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of fullname
     */
    public function getFullname(): string
    {
        return $this->fullname;
    }

    /**
     * Set the value of fullname
     */
    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     */
    public function setPhone(?PhoneNumber $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of subject
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip):static
    {
        $this->ip = $ip;

        return $this;
    }    

}