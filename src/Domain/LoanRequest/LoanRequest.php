<?php
namespace App\Domain\LoanRequest;

use libphonenumber\PhoneNumber;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\SharedModel\CreatedAt;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[ORM\Entity]
#[Vich\Uploadable]
class LoanRequest 
{
    use CreatedAt;

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'integer')]
    protected ?int $id = null;

    private string $lastname;

    private string $firstname;

    private string $email;


    #[ORM\Column(type: 'phone_number')]
    protected PhoneNumber $phone;

    private string $country;

    private string $city;

    private string $adresse;

    private float|int $montant;

    private string $devise;

    private int $duration;

    private string $subject;
    
    private string $identitydocumentname;

    private string $identityphotoname1;

    private string $identityphotoname2;

    #[Vich\UploadableField(
        mapping: 'identitydocument', 
        fileNameProperty: 'identitydocumentname', 
       )]
    private File  $identitydocumentfile;

    #[Vich\UploadableField(
        mapping: ' identityphoto',
        fileNameProperty: 'identityphotoname1',
    )]
    private File  $identityphotofile1;

    #[Vich\UploadableField(
        mapping: ' identityphoto',
        fileNameProperty: 'identityphotoname2',
    )]
    private File $identityphotofile2;

    private bool $consentcheckbox;

    

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * Get the value of lastname
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of country
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Set the value of country
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of city
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Set the value of city
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of adresse
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     */
    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Set the value of montant
     */
    public function setMontant(float|int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get the value of devise
     */
    public function getDevise(): string
    {
        return $this->devise;
    }

    /**
     * Set the value of devise
     */
    public function setDevise(string $devise): self
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get the value of duration
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the value of identitydocumentname
     */
    public function getIdentitydocumentname(): string
    {
        return $this->identitydocumentname;
    }

    /**
     * Set the value of identitydocumentname
     */
    public function setIdentitydocumentname(string $identitydocumentname): self
    {
        $this->identitydocumentname = $identitydocumentname;

        return $this;
    }

    /**
     * Get the value of identityphotoname1
     */
    public function getIdentityphotoname1(): string
    {
        return $this->identityphotoname1;
    }

    /**
     * Set the value of identityphotoname1
     */
    public function setIdentityphotoname1(string $identityphotoname1): self
    {
        $this->identityphotoname1 = $identityphotoname1;

        return $this;
    }

    /**
     * Get the value of identityphotoname2
     */
    public function getIdentityphotoname2(): string
    {
        return $this->identityphotoname2;
    }

    /**
     * Set the value of identityphotoname2
     */
    public function setIdentityphotoname2(string $identityphotoname2): self
    {
        $this->identityphotoname2 = $identityphotoname2;

        return $this;
    }

    /**
     * Get the value of identitydocumentfile
     */
    public function getIdentitydocumentfile(): File
    {
        return $this->identitydocumentfile;
    }

    /**
     * Set the value of identitydocumentfile
     */
    public function setIdentitydocumentfile(File $identitydocumentfile): self
    {
        $this->identitydocumentfile = $identitydocumentfile;

        return $this;
    }

    /**
     * Get the value of identityphotonamefile1
     */
    public function getIdentityphotofile1(): File
    {
        return $this->identityphotofile1;
    }

    /**
     * Set the value of identityphotonamefile1
     */
    public function setIdentityphotofile1(File $identityphotofile1): self
    {
        $this->identityphotofile1 = $identityphotofile1;

        return $this;
    }

    /**
     * Get the value of identityphotonamefile2
     */
    public function getIdentityphotofile2(): File
    {
        return $this->identityphotofile2;
    }

    /**
     * Set the value of identityphotonamefile2
     */
    public function setIdentityphotofile2(File $identityphotofile2): self
    {
        $this->identityphotofile2 = $identityphotofile2;

        return $this;
    }


    /**
     * Get the value of montant
     */
    public function getMontant(): float|int
    {
        return $this->montant;
    }

    /**
     * Get the value of consentcheckbox
     */
    public function isConsentcheckbox(): bool
    {
        return $this->consentcheckbox;
    }

    /**
     * Set the value of consentcheckbox
     */
    public function setConsentcheckbox(bool $consentcheckbox): self
    {
        $this->consentcheckbox = $consentcheckbox;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone(): PhoneNumber
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     */
    public function setPhone(PhoneNumber $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of subject
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
