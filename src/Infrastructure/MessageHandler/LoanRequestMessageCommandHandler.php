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
namespace App\Infrastructure\MessageHandler;

use DateTimeImmutable;
use Symfony\Component\Intl\Countries;
use App\Domain\LoanRequest\LoanRequest;
use Symfony\Component\Messenger\Envelope;
use Vich\UploaderBundle\Handler\UploadHandler;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Infrastructure\Services\ProcessUploadedFiles;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Domain\LoanRequest\LoanRequestRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Application\UseCase\Command\LoanRequestMessageCommand;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use App\Application\UseCase\Command\AdminNotificationMessageCommand;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
#[AsMessageHandler(fromTransport: 'async',handles:LoanRequestMessageCommand::class)]
final class LoanRequestMessageCommandHandler 
{
    public function __construct(
        private readonly LoanRequestRepositoryInterface $manageRegistryRequest,
        private readonly MessageBusInterface $bus,
        private UploadHandler $uploadHandler,
        private readonly ProcessUploadedFiles $process_uploaded ,
        private EntityManagerInterface $em        )
    {
        
    }
    public function __invoke(LoanRequestMessageCommand $commandRequest)
    {
        $loan_request=new LoanRequest();

        $loan_request
            ->setLastname($commandRequest->lastname)
            ->setFirstname($commandRequest->firstname)
            ->setEmail($commandRequest->email)
            ->setPhone($commandRequest->phone)
            ->setAdresse($commandRequest->adresse)
            ->setCountry(Countries::getAlpha3Name($commandRequest->country))
            ->setCity($commandRequest->city)
            ->setMontant($commandRequest->montant)
            ->setDevise($commandRequest->devise)
            ->setDuration($commandRequest->duration)
            ->setSubject($commandRequest->subject)
            ->setIdentitydocumentfile(new File($commandRequest->identitydocumentfilepath))
            ->setIdentityphotofile1(new File($commandRequest->identityphotofile1path))
            ->setIdentityphotofile2(new File($commandRequest->identityphotofile2path))
            ->setConsentcheckbox($commandRequest->consentcheckbox)
        ;
        $loan_request->setUpdatedAt(new \DateTimeImmutable());
        $this->uploadHandler->upload($loan_request, 'identitydocumentfile');
        $this->uploadHandler->upload($loan_request, 'identityphotofile1');
        $this->uploadHandler->upload($loan_request, 'identityphotofile2');
        dd($loan_request);
        $this->em->persist($loan_request);
        $this->em->flush();
        /**
         * @var LoanRequest
         */
        $loan_request_persist=$loan_request;
        $this->process_uploaded->removeFiles([
        $commandRequest->identitydocumentfilepath, 
        $commandRequest->identityphotofile1path,
            $commandRequest->identityphotofile2path
        ]);
        $event_loan_request= new AdminNotificationMessageCommand(
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
        );
        $this->bus->dispatch(
                (new Envelope($event_loan_request))->with(new DispatchAfterCurrentBusStamp())
            );
    }
}
