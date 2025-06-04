<?php
namespace App\Http\Controller\Contact;

use App\Form\ContactFormType;
use App\Message\ContactMessage;
use App\Model\ContactFormModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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
    #[Route('create',name:'contact.form.us',methods: ['POST','GET'])]
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
                    'title' => $translator->trans('Form.Error.title', [], 'Validators', $requestContactForm->getLocale()),
                    'details' => $translator->trans('Form.Error.detail', [], 'Validators', $requestContactForm->getLocale()),
                    'violations' => $formErrorHandle->handleFormData(
                        $modelContactForm,
                        'Validators',
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
          $bus->dispatch(new ContactMessage(
                $contactData->fullname,
                $contactData->email,
                $contactData->phone,
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