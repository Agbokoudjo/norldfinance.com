<?php
namespace App\Form;

use App\Model\ContactFormModel;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\{FormBuilderInterface,AbstractType};
use Symfony\Component\Form\Extension\Core\Type\{TextType, EmailType, TextareaType, TelType};

final class ContactFormType extends AbstractType{
    public function __construct(private TranslatorInterface $translator) {}
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('fullname',TextType::class,[
            'label'=>'fullname',
            'label_attr'=>['class'=> 'form-label fw-bold'],
            'attr'=>[
                'placeholder' => 'Ex:Jean Dupond',
                'autocomplete' => 'on', // corrigé
                'minlength' => 6,       // corrigé
                'maxlength' => 200,     // corrigé
                'data-pattern' => '^[\p{L}\p{M}\s\']+$',
                'data-eg-await'=> 'AGBOKOUDJO Franck',
                'data-escapestrip-html-and-php-tags'=>true,
                'data-event-validate-blur'=>'blur',
                'data-event-validate-input'=>'input',
                'class'=> 'username',
                'data-position-lastname' =>"left"
            ]
        ])
            ->add('email', EmailType::class,[
                'label' => 'email',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => [
                    'placeholder' => 'votre.email@example.com',
                    'autocomplete' => 'on',
                'data-escapestrip-html-and-php-tags' => false,
                'data-event-validate-blur' => 'blur',
                'data-event-validate-input' => 'input',
                'data-type'=>'email'
            ]
            ])
            ->add('phone',  PhoneNumberType::class, [
                'label' => 'phone',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'required' => true,
                'format' => PhoneNumberFormat::INTERNATIONAL,
                'attr' => [
                    'placeholder' => 'Ex: +33 XX XX XX XX',
                    'data-escapestrip-html-and-php-tags' => true,
                    'data-event-validate-blur' => 'blur',
                    'data-event-validate-input' => 'input',
                    "data-eg-await" => '+33 XX XX XX XX',
                    'autocomplete' => 'on',
                    'minlength' => 8,
                    'maxlength' => 80,
                    'data-type'  => 'tel'
                ]
            ])
            ->add('subject', TextType::class,[
                'label' => 'subject.label',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => [
                    'placeholder' => 'subject.placeholder',
                    'autocomplete' => 'on', // corrigé
                     'minlength' => 10,      // corrigé
                     'maxlength' => 255,     // corrigé
                'data-eg-await' => $this->translator->trans('subject.placeholder'),
                'data-escapestrip-html-and-php-tags' => true,
                'data-event-validate-blur' => 'blur',
                'data-event-validate-input' => 'input',
                'data-pattern' => "^[\p{L}\p{M}\p{N}\s\.,!\'\"()\-]+$" // Regex unicode compatible
            ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'content.label',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => [
                    'placeholder' => 'content.placeholder',
                    'autocomplete' => 'on', // 'true' n’est pas une valeur valide ici
                'minlength' => 20, // corriger la faute de frappe (min-lenght)
                'maxlength' => 20000, // corriger la faute de frappe (max-lenght)
                'data-escapestrip-html-and-php-tags' => 'true', // custom attribute (JS)
                'data-event-validate-blur' => 'blur',
                    'data-event-validate-input' => 'input',
                'data-pattern' => "^[\p{L}\p{N}\s.,;:!?'\"\(\)\[\]\-_]+$", // Corrigé
                    'rows' => 5
                ]
            ])

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class'=>ContactFormModel::class,
            'translation_domain'=> 'ContactForm'
        ]);
    }
}