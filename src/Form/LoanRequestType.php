<?php
namespace App\Form;

use App\Model\LoanRequestModel;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Intl\Currencies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, CountryType, CurrencyType, TextType, EmailType, TelType};

final class LoanRequestType extends AbstractType
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly ParameterBagInterface $services,
        private readonly RequestStack $requestStack
    ) {
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $request = $this->requestStack->getCurrentRequest();
        $locale=null;
        if ($request) {
            $locale = $request->getLocale(); // ou bien $request->getPreferredLanguage()
        }

        $builder->add('lastname', TextType::class, [
            'label' => 'lastname',
            'label_attr' => ['class' => 'form-label fw-bold'],
            'attr' => [
                'placeholder' => 'AGBOKOUDJO',
                'autocomplete' => 'on', // corrigé
                'minlength' => 6,       // corrigé
                'maxlength' => 200,     // corrigé
                'data-pattern' => '^[\p{L}\p{M}]+$',
                'data-eg-await' => 'AGBOKOUDJO',
                'data-escapestrip-html-and-php-tags' => true,
                'data-event-validate-blur' => 'blur',
                'data-event-validate-input' => 'input',
                'class' => 'lastname',
            ]
        ])
        ->add('firstname', TextType::class, [
            'label' => 'firstname',
            'label_attr' => ['class' => 'form-label fw-bold'],
            'attr' => [
                'placeholder' => 'Ex: Hounha Franck',
                'autocomplete' => 'on', // corrigé
                'minlength' => 6,       // corrigé
                'maxlength' => 200,     // corrigé
                'data-pattern' => '^[\p{L}\p{M}\s\']+$',
                'data-eg-await' => 'Hounha Franck',
                'data-escapestrip-html-and-php-tags' => true,
                'data-event-validate-blur' => 'blur',
                'data-event-validate-input' => 'input',
                'class' => 'firstname'
            ]
        ])
            ->add('email', EmailType::class, [
                'label' => 'email',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => [
                    'placeholder' => 'franckagbokoudjo301@gmail.com',
                    'autocomplete' => 'on',
                    'data-escapestrip-html-and-php-tags' => false,
                    'data-event-validate-blur' => 'blur',
                    'data-event-validate-input' => 'input',
                    'data-eg-await'=> 'franckagbokoudjo301@gmail.com',
                    'data-type'=>'email'
                ]
            ])
            ->add('phone',  PhoneNumberType::class, [
                'label' => 'phone',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'required' => true,
                'format' => PhoneNumberFormat::INTERNATIONAL,
                'attr' => [
                    'placeholder' => '+229 XX XX XX XX',
                    'data-escapestrip-html-and-php-tags' => true,
                    'data-event-validate-blur' => 'blur',
                    'data-event-validate-input' => 'input',
                    "data-eg-await" => '+229 XX XX XX XX',
                    'autocomplete' => 'on', 
                    'minlength' => 8,      
                    'maxlength' => 80,
                    'data-type'  =>'tel'   
                ]
            ])
            ->add('country',CountryType::class,[
                'label' => 'country.placeholder',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'required' => true,
                "alpha3"=>true,
            'choice_translation_domain'=>true,
                'attr' => [
                    'data-escapestrip-html-and-php-tags' => true,
                    'data-event-validate-change' => 'change',
                'data-event-validate-blur' => 'blur',
                    'autocomplete' => 'on', // corrigé
                    'minlength' => 3,      // corrigé
                    'maxlength' => 150,     // corrigé,
                    'data-pattern'=> '^[\p{L}\p{M}\s\'-]+$',
                'class' => 'form-control select2 form-select form-select-lg',
                'data-placeholder'=> 'country.placeholder',
                'data-minimumInputLength'=>3
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'city',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'required' => true,
                'attr' => [
                    'placeholder' => 'Paris',
                    'data-escapestrip-html-and-php-tags' => true,
                    'data-event-validate-blur' => 'blur',
                    'data-event-validate-input' => 'input',
                    "data-eg-await" => 'Paris',
                    'autocomplete' => 'on', // corrigé
                    'minlength' => 2,      // corrigé
                    'maxlength' => 150,     // corrigé,
                    'data-pattern' => '^[\p{L}\p{M}0-9\s\'-]+$'
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'adresse',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'required' => true,
                'help_html'=>true,
            'help' => sprintf(
                '<div class="form-text text-muted">%s</div>',
                $this->translator->trans('adresse.helper', [], 'LoanRequest', $locale)
            ),
                'attr' => [
                    'placeholder' => 'adresse.placeholder',
                    'data-escapestrip-html-and-php-tags' => true,
                    'data-event-validate-blur' => 'blur',
                    'data-event-validate-input' => 'input',
                    "data-eg-await" => $this->translator->trans('adresse.helper',[],'LoanRequest',$locale),
                    'autocomplete' => 'on', // corrigé
                    'minlength' => 2,      // corrigé
                    'maxlength' => 150,     // corrigé,
                    'data-pattern' => '^[\p{L}\p{N}\p{M}\s\',.\-()/#]+$'
                ]
            ])
            ->add('montant',NumberType::class,[
                'label' => 'montant',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'required' => true,
                'attr' => [
                'placeholder' => 'Ex:5000000',
                    'data-escapestrip-html-and-php-tags' => true,
                    'data-event-validate-blur' => 'blur',
                    'data-event-validate-input' => 'input',
                    "data-eg-await" => '500000',
                    'autocomplete' => 'on', // corrigé
                    'data-pattern' => '^[\p{N}\.]+$',
                    'data-type'=>'number'
                ]
            ])
            ->add('devise',CurrencyType::class,[
                'label' => 'devise',
                'required' => true,
            'choice_translation_domain'=>true,
            'choice_label' => function (string $currencyCode) use ($locale) {
                return sprintf('%s (%s)', Currencies::getName($currencyCode, $locale), $currencyCode);
            },
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr'=>[
                    'data-pattern'=> '[A-Z\p{M}]+$',
                'data-escapestrip-html-and-php-tags' => true,
                'data-event-validate-blur' => 'blur',
                'data-event-validate-change' => 'change',
                'autocomplete' => 'on',
                'class' => 'form-control select2 form-select form-select-lg',
                'data-placeholder' => 'devise.placeholder',
                'data-minimumInputLength' => 3
            ]
            ])
            ->add('duration',NumberType::class,[
            'label' => 'duration',
            'required' => true,
            'label_attr' => ['class' => 'form-label fw-bold'],
            'attr' => [
                'data-pattern' => '[0-9]+$',
                'placeholder' => 'Ex:5',
                'data-escapestrip-html-and-php-tags' => true,
                'data-event-validate-blur' => 'blur',
                'data-event-validate-input' => 'input',
                'data-event-validate-change' => 'change',
                'autocomplete' => 'on',
                'min'=>1
            ]
            ])
            ->add('subject', TextType::class, [
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
            ->add('identitydocumentfile', FileType::class,[
                'label' => 'identitydocument',
                'required' => true,
                'label_attr' => ['class' => 'form-label fw-bold'],
            'attr' => [
                'data-event-validate-blur' => 'blur',
                'data-event-validate-change' => 'change',
                'data-media-type'=>'document',
                'data-extentions'=>'pdf',
                'data-unity-max-size-file'=>'MiB',
                'data-maxsize-file'=>'10',
                'data-allowed-mime-type-accept'=> 'application/x-pdf,application/pdf',
                'accept'=> 'application/x-pdf,application/pdf'
            ]
            ])
            ->add('identityphotofile1', FileType::class, [
                'label' => 'identityphoto1',
                'required' => true,
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => [
                    'data-event-validate-blur' => 'blur',
                    'data-event-validate-change' => 'change',
                    'data-media-type' => 'image',
                    'data-extentions' => 'jpg,pnf,jpeg',
                    'data-unity-max-size-file' => 'MiB',
                    'data-maxsize-file' => 5,
                    'data-allowed-mime-type-accept' => 'image/jpg,image/png,image/jpeg',
                'data-min-width' => 50,
                'data-max-width' => 500,
                'data-min-height' => 50,
                'data-max-height' => 500,
                'accept'=> 'image/jpg,image/png,image/jpeg'
                ]
            ])
            ->add('identityphotofile2', FileType::class, [
                'label' => 'identityphoto2',
                'required' => true,
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => [
                    'data-event-validate-blur' => 'blur',
                    'data-event-validate-change' => 'change',
                    'data-media-type' => 'image',
                    'data-extentions' => 'jpg,pnf,jpeg',
                    'data-unity-max-size-file' => 'MiB',
                    'data-maxsize-file' => 5,
                    'data-allowed-mime-type-accept' => 'image/jpg,image/png,image/jpeg',
                    'data-min-width' => 50,
                    'data-max-width' => 500,
                    'data-min-height' => 50,
                    'data-max-height' => 500,
                    'accept'=> 'image/jpg,image/png,image/jpeg'
                ]
            ])
            ->add('consentcheckbox', CheckboxType::class, [
                'label' => $this->translator->trans(
                    'consentCheckbox',
                    ['%organization_name%' => $this->services->get('NAME_SITE')],
                    'LoanRequest',
                    $locale
                ),
                'label_attr' => ['class' => 'form-check-label text-muted'],
                'label_html' => true,
                'required' => true,
                'attr'=>[
                    'class'=>'border border-2 border-warning h2',
                    'role'=> 'switch',
                    'data-type'=>'checkbox'
                ]
            ])

        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LoanRequestModel::class,
            'csrf_protection' => true, // Généralement true par défaut, mais peut être explicité
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'loan_request_item',
            'translation_domain' => 'LoanRequest'
        ]);
    }
}
