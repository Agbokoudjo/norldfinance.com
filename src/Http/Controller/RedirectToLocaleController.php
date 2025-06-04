<?php
// src/Http/Controller/RedirectToLocaleController.php
namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RedirectToLocaleController
{
    #[Route(path: '/', name: 'redirect_to_locale')]
    public function __invoke(Request $request): RedirectResponse
    {
        // Essaie de récupérer la langue stockée en session
        $locale = $request->getSession()->get('_locale',$request->getDefaultLocale());

        // Sinon, détecte la langue préférée du navigateur (ou 'fr' par défaut)
        $preferredLocale = $locale ?? $request->getPreferredLanguage(['fr', 'en', 'de', 'es', 'it', 'nl', 'pt']);

        return new RedirectResponse("/$preferredLocale/",301);
    }
}
