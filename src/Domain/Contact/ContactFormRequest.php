<?php
namespace App\Domain\Contact;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contact\AbstractContactData;
use libphonenumber\PhoneNumber;

#[ORM\Entity]
class ContactFormRequest extends AbstractContactData{
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'integer')]
    protected ?int $id = null;

    #[ORM\Column(type: 'phone_number')]
    protected ?PhoneNumber $phone=null;
    #[ORM\Column(type: 'string')]
    private string $ip = '';
    public function __construct(
    )
    {
       
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