<?php
namespace App\MessageHandler;

use DateTimeImmutable;
use App\Message\LoanRequestMessage;
use Symfony\Component\Intl\Countries;
use App\Domain\LoanRequest\LoanRequest;
use App\Domain\LoanRequest\LoanRequestRepositoryInterface;
use App\Message\AdminNotificationMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class LoanRequestMessageHandler 
{
    public function __construct(
        private readonly LoanRequestRepositoryInterface $loanRequestRepository,
        private readonly MessageBusInterface $bus 
        )
    {
        
    }
    public function __invoke(LoanRequestMessage $loan_request_message)
    {
        $loan_request=new LoanRequest();
        $loan_request
            ->setLastname($loan_request_message->lastname)
            ->setFirstname($loan_request_message->firstname)
            ->setEmail($loan_request_message->email)
            ->setPhone($loan_request_message->phone)
            ->setAdresse($loan_request_message->adresse)
            ->setCountry(Countries::getAlpha3Name($loan_request_message->country))
            ->setCity($loan_request_message->city)
            ->setMontant($loan_request_message->montant)
            ->setDevise($loan_request_message->devise)
            ->setDuration($loan_request_message->duration)
            ->setSubject($loan_request_message->subject)
            ->setIdentitydocumentfile($loan_request_message->identitydocumentfile)
            ->setIdentityphotofile1($loan_request_message->identityphotofile1)
            ->setIdentityphotofile2($loan_request_message->identityphotofile2)
            ->setConsentcheckbox($loan_request_message->consentcheckbox)
            ->setCreatedAt(new DateTimeImmutable())
        ;
        /**
         * @var LoanRequest
         */
        $loan_request_persist=$this->loanRequestRepository->add($loan_request,true);

       $this->bus->dispatch(
            new AdminNotificationMessage(
                $loan_request_persist->getLastname(),
                $loan_request_persist->getFirstname(),
                $loan_request_persist->getEmail(),
                $loan_request_persist->getPhone(),
                $loan_request_persist->getCountry(),
                $loan_request_persist->getCity(),
                $loan_request_persist->getAdresse(),
                $loan_request_persist->getMontant(),
                $loan_request_persist->getDevise(),
                $loan_request_persist->getDuration(),
                $loan_request_persist->getSubject(),
                $loan_request_persist->getIdentitydocumentname(),
                $loan_request_persist->getIdentityphotoname1(),
                $loan_request_persist->getIdentityphotoname2(),
                $loan_request_persist->isConsentcheckbox(),
            )
            );
    }
}
