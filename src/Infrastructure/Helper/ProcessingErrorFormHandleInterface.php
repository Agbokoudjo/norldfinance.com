<?php
namespace App\Infrastructure\Helper;

use Symfony\Component\Form\FormInterface;
interface ProcessingErrorFormHandleInterface{
    public function handleFormData(FormInterface $form,
        ?string $domain = null,
        ?string $locales = null):array;
}