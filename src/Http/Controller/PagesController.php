<?php
namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('desactiver-pages/')]
final class PagesController extends AbstractController
{
    #[Route('privacy-policy',name: 'pages.privacy.policy',methods:['GET'])]
    public function privacyPolicy():Response{
        return $this->render('pages/privacy_policy.html.twig');
    }
    #[Route('terms-and-conditions', name: 'pages.terms.and.conditions', methods: ['GET'])]
    public function termsConditions():Response{
        return $this->render('pages/terms_and_conditions.html.twig');
    }
}
