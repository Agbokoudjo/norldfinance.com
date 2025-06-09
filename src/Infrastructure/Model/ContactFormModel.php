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

namespace App\Infrastructure\Model;

use libphonenumber\PhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
final class ContactFormModel
{
    public function __construct(
        #[Assert\NotBlank(message: 'validator.fullname.not_blank')]
        #[Assert\NotNull(message: 'validator.fullname.not_null')]
        #[Assert\Length(
            min: 6,
            max: 200,
            minMessage: 'validator.fullname.length',
            maxMessage: 'validator.fullname.length'
        )]
        #[Assert\Regex(
            pattern: "/^[\p{L}\p{M}\s\-\'\.]{2,200}$/u",
            message: 'validator.contact_form.fullname.regex',
            match: true
        )]
        public ?string $fullname = null,
        #[Assert\NotBlank(message: 'validator.email.not_blank')]
        #[Assert\NotNull(message: 'validator.email.not_null')]
        #[Assert\Length(
            min: 6, 
            max: 180,
            minMessage: 'validator.email.length',
            maxMessage: 'validator.email.length'
        )]
        #[Assert\Email(message: 'validator.email.invalid')]
        public ?string $email = null,

        #[Assert\Length(max: 80)]
        #[AssertPhoneNumber()]
        public ?PhoneNumber $phone = null,

        #[Assert\NotBlank(message: 'validator.contact_form.subject.not_blank')]
        #[Assert\NotNull(message: 'validator.contact_form.subject.not_null')]
        #[Assert\Length(
            min: 10, 
             max: 255,
            minMessage: 'validator.contact_form.email.length',
            maxMessage: 'validator.contact_form.email.length'
             )]
        #[Assert\Regex(
            pattern: "/^[\p{L}\p{M}\p{N}\s\.,;:!?\'\"()\-]+$/u",
            match: true,
            message: 'validator.contact_form.subject.regex'
        )]
        public ?string $subject = null,

        #[Assert\NotBlank(message: 'validator.contact_form.content.not_blank')]
        #[Assert\Length(
         min: 20,
         max: 20000,
         )]
        #[Assert\Regex(
            pattern: "/^[\p{L}\p{M}\p{N}\s.,;:!?\"'’()\[\]\-–—_€$%°\n\r]+$/u",
            match: true,
            message: 'validator.contact_form.content.regex'
        )]
        public ?string $content = null
    ) {}
}
