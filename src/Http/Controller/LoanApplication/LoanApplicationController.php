<?php
namespace App\Http\Controller\LoanApplication;

use App\Http\Form\LoanRequestType;
use Symfony\Component\Intl\Countries;
use App\Domain\LoanRequest\LoanRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Model\LoanRequestModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Infrastructure\Services\ProcessUploadedFiles;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Domain\LoanRequest\LoanRequestRepositoryInterface;
use App\Application\UseCase\Command\LoanRequestMessageCommand;
use App\Infrastructure\Helper\ProcessingErrorFormHandleInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\UseCase\Command\AdminNotificationMessageCommand;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/loan-application-credit/')]
final class LoanApplicationController extends AbstractController{
    public function __construct(
        private readonly ParameterBagInterface $servicesController,
        private ProcessUploadedFiles $uploadedFiles
        )
    {
        
    }
    #[Route(path:'request/new',
            name:"loan.application.credit",
            methods:['POST','GET'],
            options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ]
    )]
    public function create(
        Request $request,
        ProcessingErrorFormHandleInterface $formErrorHandle,
        TranslatorInterface $translator,
        MessageBusInterface $bus,
        LoanRequestRepositoryInterface $registryRequest
        ):Response{
        $form_loan_application=$this->createForm(LoanRequestType::class,new LoanRequestModel());
        $form_loan_application->handleRequest($request);
        if($form_loan_application->isSubmitted()){
            if(!$form_loan_application->isValid()){
                return $this->json([
                    'title' => $translator->trans('Form.Error.title', [], 'validators', $request->getLocale()),
                    'details' => $translator->trans('Form.Error.detail', [], 'validators', $request->getLocale()),
                    'violations' => $formErrorHandle->handleFormData(
                        $form_loan_application,
                        'validators',
                        $request->getLocale()
                    ),
                    'formName' => $form_loan_application->getName()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            /**
             * @var LoanRequestModel ;
             */
            $loan_request_model=$form_loan_application->getData();
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
            $registryRequest->add($loan_request,true);
           $bus->dispatch( new AdminNotificationMessageCommand(
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
            return $this->json([
                'title' => $translator->trans(
                    'Form.success.title',
                    [
                        '%name%' => sprintf('%s %s', $loan_request_model->lastname, $loan_request_model->firstname),
                    ],
                    'LoanRequest',
                    $request->getLocale()
                ),
                'message' => $translator->trans(
                    'Form.success.message',
                    [
                        '%name%' =>  sprintf('%s %s', $loan_request_model->lastname, $loan_request_model->firstname),
                        '%organization%' => sprintf('<strong style="color: #ea3249">%s</strong>', $this->servicesController->get('NAME_SITE')),
                    ],
                    'LoanRequest',
                    $request->getLocale()
                )
            ], Response::HTTP_CREATED);
        }
        return $this->render('loanapplication/index.html.twig',[
            'form'=>$form_loan_application
        ]);
    }
}