<?php
namespace App\Message;

use libphonenumber\PhoneNumber;
use Symfony\Component\HttpFoundation\File\File;

final class LoanRequestMessage 
{
    public function __construct(
        public readonly string $lastname ,
        public readonly string $firstname,
        public readonly string $email ,
        public readonly PhoneNumber $phone ,
        public readonly string $country,
        public readonly string $city,
        public readonly string $adresse,
        public readonly float|int $montant,
        public readonly string $devise ,
        public readonly int $duration,
        public readonly string $subject,
        public readonly File $identitydocumentfile,
        public readonly File  $identityphotofile1,
        public readonly File  $identityphotofile2,
        public readonly bool $consentcheckbox
    ) {}
}
