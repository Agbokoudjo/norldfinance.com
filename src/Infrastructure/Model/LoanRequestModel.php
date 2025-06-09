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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
final class LoanRequestModel 
{
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Length(
            min: 2,
            max: 200
        )]
        #[Assert\Regex(
            pattern: "/^[\p{L}\p{M}\s']+$/u",
            match:true
        )]
        public ?string $lastname = null,

        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Length(
            min: 2,
            max: 200
        )]
        #[Assert\Regex(
            pattern: "/^[\p{L}\p{M}\s']+$/u",
            match:true
        )]
        public ?string $firstname = null,

        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Length(
            min: 6,
            max: 180
        )]
        #[Assert\Email()]
        public ?string $email = null,

        #[Assert\Length(max: 80)]
        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[AssertPhoneNumber(regionPath: 'country')]
        public ?PhoneNumber $phone = null,

        #[Assert\Country(alpha3: true)]
        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Regex(
            pattern: '/^[\p{L}\p{M}\s\'-]+$/u',
            match:true
        )]
        #[Assert\Length(
            min: 3, // Les pays les plus courts ont 2 lettres (ex: "Togo")
            max: 150, // Pour les noms longs (ex: "Royaume-Uni de Grande-Bretagne et d'Irlande du Nord")
        )]
        public ?string $country=null,
        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Regex(
            pattern: '/^[\p{L}\p{M}0-9\s\'-.]+$/u',
            match: true
        )]
        #[Assert\Length(
            min: 2,
            max: 150,
        )]
        public ?string $city=null,

        #[Assert\NotBlank(message: "L'adresse ne peut pas être vide.")]
        #[Assert\Regex(
            pattern: '/^[\p{L}\p{N}\p{M}\s\',.\-()\/\#]+$/u',
            match: true
        )]
        #[Assert\Length(
            min: 5, // Une adresse devrait avoir au moins quelques caractères
            max: 255
        )]
        public ?string $adresse=null,

        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Positive()]
        public float|int|null $montant=null,
        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Currency()]
        #[Assert\Regex(
            pattern: '/^[A-Z\p{M}]+$/u',
            match: true
        )]
        public ?string $devise=null,

        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Range(
            min:1
        )]
        #[Assert\Regex(
            pattern: '/^[0-9]+$/',
            match: true
        )]
        public ?int $duration=null,
        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\Length(
            min: 10,
            max: 255
        )]
        #[Assert\Regex(
            pattern: "/^[\p{L}\p{M}\p{N}\s\.,!\'\"()\-]+$/u",
            match: true
        )]
        public ?string $subject = null,

        #[Assert\NotBlank()]
        #[Assert\NotNull()]
        #[Assert\File(
            mimeTypes:["application/pdf", "application/x-pdf"],
            maxSize:"10240ki",
            extensions: ['pdf'],
            filenameMaxLength:255
        )]
        public ?File $identitydocumentfile=null,

        #[Assert\Image(
            maxSize: '5120ki', // Exemple: taille maximale de 5 mégaoctets
            mimeTypes: ['image/jpeg', 'image/png', "image/jpg"], // Types MIME acceptés
            filenameMaxLength: 255,
            maxWidth:500,
            maxHeight: 500,
            minWidth:50,
            minHeight:50
        )]
        public ?File  $identityphotofile1=null,

        #[Assert\Image(
            maxSize: '5120ki', // Exemple: taille maximale de 5 mégaoctets
            mimeTypes: ['image/jpeg', 'image/png', "image/jpg"], // Types MIME acceptés
            filenameMaxLength: 255,
            maxWidth: 500,
            maxHeight: 500,
            minWidth: 50,
            minHeight: 50
        )]
        public ?File  $identityphotofile2 = null,

        #[Assert\IsTrue(message: "validator.consentCheckbox")]
        public ?bool $consentcheckbox=null
    )
    {
        
    }
}
