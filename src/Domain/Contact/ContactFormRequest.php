<?php
namespace App\Domain\Contact;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contact\AbstractContactData;

#[ORM\Entity]
class ContactFormRequest extends AbstractContactData{
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