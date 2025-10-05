<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Symfony\Component\Intl\Countries;
use App\Domain\LoanRequest\LoanRequest;
use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Repository\CrudTrait;
use App\Infrastructure\Model\LoanRequestModel;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Domain\LoanRequest\LoanRequestRepositoryInterface;
use App\Application\UseCase\Command\AdminNotificationMessageCommand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<LoanRequest>
 */
final class LoanRequestRepository extends ServiceEntityRepository implements LoanRequestRepositoryInterface
{
    use CrudTrait;
    public function __construct(
        ManagerRegistry $registry,
        private MessageBusInterface $bus,
    ) {
        parent::__construct($registry, LoanRequest::class);
    }

    public function create(LoanRequestModel $loan_request_model):void{

        $loan_request = new LoanRequest();
        $loan_request
            ->setLastname($loan_request_model->lastname)
            ->setFirstname($loan_request_model->firstname)
            ->setEmail($loan_request_model->email)
            ->setPhone($loan_request_model->phone)
            ->setAdresse($loan_request_model->adresse)
            ->setCountry(Countries::getAlpha3Name($loan_request_model->country))
            ->setCity($loan_request_model->city)
            ->setMontant($loan_request_model->montant)
            ->setDevise($loan_request_model->devise)
            ->setDuration($loan_request_model->duration)
            ->setSubject($loan_request_model->subject)
            ->setIdentitydocumentfile($loan_request_model->identitydocumentfile)
            ->setIdentityphotofile1($loan_request_model->identityphotofile1)
            ->setIdentityphotofile2($loan_request_model->identityphotofile2)
            ->setConsentcheckbox($loan_request_model->consentcheckbox)
        ;
        $loan_request->setUpdatedAt(new \DateTimeImmutable());
        $this->add($loan_request, true);

        $this->bus->dispatch(new AdminNotificationMessageCommand(
            $loan_request->getLastname(),
            $loan_request->getFirstname(),
            $loan_request->getEmail(),
            $loan_request->getPhone(),
            $loan_request->getCountry(),
            $loan_request->getCity(),
            $loan_request->getAdresse(),
            $loan_request->getMontant(),
            $loan_request->getDevise(),
            $loan_request->getDuration(),
            $loan_request->getSubject(),
            $loan_request->getIdentitydocumentname(),
            $loan_request->getIdentityphotoname1(),
            $loan_request->getIdentityphotoname2(),
            $loan_request->isConsentcheckbox(),
        ));
    }
}
