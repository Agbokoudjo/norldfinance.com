<?php

declare(strict_types=1);
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

use libphonenumber\PhoneNumber;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
final class ContactFormCommand
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $subject,
        public readonly string $content,
        public readonly string $ip,
        public readonly PhoneNumber $phone
    ) {}
}
