<?php
namespace App\Domain\SharedModel;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAt
{
    #[ORM\Column(type: "datetime_immutable")]
    protected DateTimeInterface $createdAt;

    public function setCreatedAt(DateTimeInterface $createdAt):static{
        $this->createdAt=$createdAt;
        return $this;
    }
    public function getCreatedAt():DateTimeInterface{return $this->createdAt;}
}
