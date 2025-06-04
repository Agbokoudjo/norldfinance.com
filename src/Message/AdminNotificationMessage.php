<?php
namespace App\Message;

use libphonenumber\PhoneNumber;

final class AdminNotificationMessage 
{
    public function __construct(
        public readonly string $lastname,
        public readonly string $firstname,
        public readonly string $email,
        public readonly PhoneNumber $phone,
        public readonly string $country,
        public readonly string $city,
        public readonly string $adresse,
        public readonly float|int $montant,
        public readonly string $devise,
        public readonly int $duration,
        public readonly string $subject,
        public readonly string $identitydocumentname,
        public readonly string  $identityphotoname1,
        public readonly string  $identityphotoname2,
        public readonly bool $consentcheckbox
    )
    {
        
    }
}
