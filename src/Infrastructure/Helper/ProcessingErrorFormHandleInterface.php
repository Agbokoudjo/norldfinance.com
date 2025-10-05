<?php

declare(strict_types=1);

namespace App\Infrastructure\Helper;

use Symfony\Component\Form\FormInterface;

interface ProcessingErrorFormHandleInterface{
    public function handleFormData(FormInterface $form,
        ?string $domain = null,
        ?string $locales = null):array;
}