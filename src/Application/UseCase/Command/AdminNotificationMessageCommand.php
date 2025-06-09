<?php
/*
 * This file is part of the project by AGBOKOUDJO Franck.
 *
 * (c) AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * Phone: +229 0167 25 18 86
 * LinkedIn: https://www.linkedin.com/in/internationales-web-services-120520193/
 * Github: https://github.com/Agbokoudjo/norldfinance.com
 * Company: INTERNATIONALES WEB SERVICES
 *
 * For more information, please feel free to contact the author.
 */

namespace App\Application\UseCase\Command;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
final class AdminNotificationMessageCommand 
{
    public function __construct(
        public readonly string $lastname,
        public readonly string $firstname,
        public readonly string $email,
        public readonly mixed $phone,
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
