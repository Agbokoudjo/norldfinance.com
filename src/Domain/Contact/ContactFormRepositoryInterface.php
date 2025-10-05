<?php

declare(strict_types=1);

namespace App\Domain\Contact;


interface ContactFormRepositoryInterface {

    public function add(ContactFormInterface $entity, bool $flush = false):void;

}