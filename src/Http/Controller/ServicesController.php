<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/services')]
final class ServicesController extends AbstractController{

    public const SIX_MONTHS_IN_SECONDS = 15778800;

    #[Route('/home',
        name:'services.home',
        methods:['GET'],
        options: [
            'sitemap' => [
                'priority' => 0.7,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY
            ]
        ])]
    #[Cache(
        public: true,
        maxage: self::SIX_MONTHS_IN_SECONDS,
        smaxage: self::SIX_MONTHS_IN_SECONDS,
        mustRevalidate: false
    )]
    public function index(Request $requestIndex):Response{
        return $this->render(sprintf('services/home/%s.html.twig',$requestIndex->getLocale()));
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
    #[Cache(
        public: true,
        maxage: self::SIX_MONTHS_IN_SECONDS,
        smaxage: self::SIX_MONTHS_IN_SECONDS,
        mustRevalidate: false
    )]
    public function professionalLoan(Request  $requestLoan): Response
    {
        return $this->render(sprintf('services/professional_loan/%s.html.twig',$requestLoan->getLocale()));
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
    #[Cache(
        public: true,
        maxage: self::SIX_MONTHS_IN_SECONDS,
        smaxage: self::SIX_MONTHS_IN_SECONDS,
        mustRevalidate: false
    )]
    public function credit(Request $request): Response
    {
        return $this->render(sprintf('services/immobilier_credit/%s.html.twig',$request->getLocale()));
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
    #[Cache(
        public: true,
        maxage: self::SIX_MONTHS_IN_SECONDS,
        smaxage: self::SIX_MONTHS_IN_SECONDS,
        mustRevalidate: false
    )]
    public function consumerCredit(Request $requestConsumer): Response
    {
        return $this->render(sprintf('services/consumer_credit/%s.html.twig', $requestConsumer->getLocale()));
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
    #[Cache(
        public: true,
        maxage: self::SIX_MONTHS_IN_SECONDS,
        smaxage: self::SIX_MONTHS_IN_SECONDS,
        mustRevalidate: false
    )]
    public function studentsLoans(Request $requestStudents): Response
    {
        return $this->render(sprintf('services/students_loans/%s.html.twig',$requestStudents->getLocale()));
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
    #[Cache(
        public: true,
        maxage: self::SIX_MONTHS_IN_SECONDS,
        smaxage: self::SIX_MONTHS_IN_SECONDS,
        mustRevalidate: false
    )]
    public function investmentFinancing(Request $requestFinancing): Response
    {
        return $this->render(sprintf('services/investment_financing/%s.html.twig', $requestFinancing->getLocale()));
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
    #[Cache(
        public: true,
        maxage: self::SIX_MONTHS_IN_SECONDS,
        smaxage: self::SIX_MONTHS_IN_SECONDS,
        mustRevalidate: false
    )]
    public function loanBuyback(Request $requestBuyback): Response
    {
        return $this->render(sprintf('services/loan_buyback/%s.html.twig',$requestBuyback->getLocale()));
    }
    
}