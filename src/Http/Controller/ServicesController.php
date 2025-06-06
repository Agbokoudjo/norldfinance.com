<?php
namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/services')]
final class ServicesController extends AbstractController{
    #[Route('/home',
        name:'services.home',
        methods:['GET'],
        options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ])]
    public function index():Response{
        return $this->render('services/index.html.twig');
    }

    #[Route('/professional-loan', 
        name: 'services.professional.loan', 
        methods: ['GET'],
        options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ])]
    public function professionalLoan(): Response
    {
        return $this->render('services/professional_loan.html.twig');
    }

    #[Route('/home-loan', 
        name: 'services.immobilier.credit', 
        methods: ['GET'],
        options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ])]
    public function credit(): Response
    {
        return $this->render('services/immobilier_credit.html.twig');
    }
    #[Route('/consumer-credit', 
        name: 'services.consumer.credit', 
        methods: ['GET'],
        options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ])]
    public function consumerCredit(): Response
    {
        return $this->render('services/consumer_credit.html.twig');
    }
    #[Route('/students-loans', 
        name: 'services.students.loans', 
        methods: ['GET'],
        options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ])]
    public function studentsLoans(): Response
    {
        return $this->render('services/students_loans.html.twig');
    }
    #[Route('/investment-financing', 
        name: 'services.investment.financing',
        methods: ['GET'],
        options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ])]
    public function investmentFinancing(): Response
    {
        return $this->render('services/investment_financing.html.twig');
    }
    #[Route('/loan-buyback', 
        name: 'services.loan.buyback',
        methods: ['GET'],
        options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ])]
    public function loanBuyback(): Response
    {
        return $this->render('services/loan_buyback.html.twig');
    }
    
}