<?php
namespace App\Http\Controller\LoanApplication;

use App\Form\LoanRequestType;
use App\Model\LoanRequestModel;
use App\Message\LoanRequestMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Infrastructure\Helper\ProcessingErrorFormHandleInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/loan-application-credit/')]
final class LoanApplicationController extends AbstractController{
    public function __construct(private readonly ParameterBagInterface $servicesController)
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
        MessageBusInterface $bus
        ):Response{
        $form_loan_application=$this->createForm(LoanRequestType::class,new LoanRequestModel());
        $form_loan_application->handleRequest($request);
        if($form_loan_application->isSubmitted()){
            if($form_loan_application->isValid()){
                return $this->json([
                    'title' => $translator->trans('Form.Error.title', [], 'Validators', $request->getLocale()),
                    'details' => $translator->trans('Form.Error.detail', [], 'Validators', $request->getLocale()),
                    'violations' => $formErrorHandle->handleFormData(
                        $form_loan_application,
                        'Validators',
                        $request->getLocale()
                    ),
                    'formName' => $form_loan_application->getName()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            /**
             * @var LoanRequestModel ;
             */
            $loan_request_model=$form_loan_application->getData();
           $bus->dispatch(new LoanRequestMessage(
                $loan_request_model->lastname,
                $loan_request_model->firstname,
                $loan_request_model->email,
                $loan_request_model->phone,
                $loan_request_model->country,
                $loan_request_model->city,
                $loan_request_model->adresse,
                $loan_request_model->montant,
                $loan_request_model->devise,
                $loan_request_model->duration,
                $loan_request_model->subject,
                $loan_request_model->identitydocumentfile,
                $loan_request_model->identityphotofile1,
                $loan_request_model->identityphotofile2,
                $loan_request_model->consentcheckbox
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