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
final class LoanRequestMessageCommand
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
        public readonly string $identitydocumentfilepath,
        public readonly string $identityphotofile1path,
        public readonly string  $identityphotofile2path,
        public readonly bool $consentcheckbox
    ) {}
}
