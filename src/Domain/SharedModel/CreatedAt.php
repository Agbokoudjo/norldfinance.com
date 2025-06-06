<?php
namespace App\Domain\SharedModel;

use DateTimeInterface;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAt
{
    #[ORM\Column(type:DateTimeType::class)]
    protected DateTimeInterface $createdAt;

    public function setCreatedAt(DateTimeInterface $createdAt):static{
        $this->createdAt=$createdAt;
        return $this;
    }
    public function getCreatedAt():DateTimeInterface{return $this->createdAt;}
}
