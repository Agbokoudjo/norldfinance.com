<?php
namespace App\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PagesController extends AbstractController{

    #[Route(
        path:'/',
        name:"home",
        methods:['GET'],
        options: ['sitemap' => true])]
    public function homeAction(Request $requestHome):Response{
        return $this->render(sprintf('home/index_%s.html.twig', $requestHome->get('_locale')));
    }
    #[Route(
        path:'/about', 
        name: 'about', 
        options: ['sitemap' => [
                    'priority' => 0.7, 
                    'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY]])]
    public function aboutAction(Request $requestAbout): Response
    {
       return $this->render(sprintf('about/about_%s.html.twig', $requestAbout->get('_locale')));
    }
}