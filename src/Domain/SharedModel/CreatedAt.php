<?php
namespace App\Domain\SharedModel;

use DateTimeInterface;

trait CreatedAt
{
    protected DateTimeInterface $createdAt;

    public function setCreatedAt(DateTimeInterface $createdAt):static{
        $this->createdAt=$createdAt;
        return $this;
    }
    public function getCreatedAt():DateTimeInterface{return $this->createdAt;}
}
