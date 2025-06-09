<?php
namespace App\Http\Controller\Contact;

use App\Application\UseCase\Command\ContactMessageCommand;
use App\Http\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Model\ContactFormModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Infrastructure\Helper\ProcessingErrorFormHandleInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/contact-us/')]
final class ContactFormController extends AbstractController{
    public function __construct(private readonly ParameterBagInterface $servicesController)
    {
        
    }
    #[Route(
        path:'create',
        name:'contact.form.us',
        methods: ['POST','GET'],
        options:['sitemap' => [
            'priority' => 0.7, 
            'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY]
       ])
    ]
    public function create(
    Request $requestContactForm,
    ProcessingErrorFormHandleInterface $formErrorHandle,
    TranslatorInterface $translator,
    MessageBusInterface $bus
    ):Response{
        $modelContactForm=$this->createForm(ContactFormType::class, new ContactFormModel());
        $modelContactForm->handleRequest($requestContactForm);
        if($modelContactForm->isSubmitted()){
            if (!$modelContactForm->isValid()) {
                return $this->json([
                    'title' => $translator->trans('Form.Error.title', [], 'validators', $requestContactForm->getLocale()),
                    'details' => $translator->trans('Form.Error.detail', [], 'validators', $requestContactForm->getLocale()),
                    'violations' => $formErrorHandle->handleFormData(
                        $modelContactForm,
                        'validators',
                        $requestContactForm->getLocale()
                    ),
                    'formName'=> $modelContactForm->getName()
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            /**
             * @var ContactFormModel
             */
            $contactData=$modelContactForm->getData();
            /**
             * Enregistrer les données du contacts dans la base de données en async avec messenger
             */
        $bus->dispatch(new ContactMessageCommand(
                $contactData->fullname,
                $contactData->email,
                $contactData->subject,
                $contactData->content,
                $requestContactForm->getClientIp(),
                $contactData->phone
            ));
            return $this->json([
                'title' => $translator->trans(
                    'Form.success.title',
                    [
                        '%name%' => $contactData->fullname,
                    ],
                    'ContactForm',
                    $requestContactForm->getLocale()
                ),
                'message' => $translator->trans(
                    'Form.success.message',
                    [
                        '%name%' => $contactData->fullname,
                        '%organization%' =>sprintf('<strong style="color: #ea3249">%s</strong>',$this->servicesController->get('NAME_SITE')),
                    ],
                    'ContactForm',
                    $requestContactForm->getLocale()
                )
                ],Response::HTTP_CREATED);
        }
        return $this->render('contact/index.html.twig',[
            'form'=>$modelContactForm
        ]);
    }
}