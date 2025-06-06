<?php
namespace App\Http\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PagesController extends AbstractController{
    #[Route('/',name:"home",methods:['GET'],options: ['sitemap' => true])]
    public function homeAction():Response{
        return $this->render('index.html.twig');
    }
    #[Route(
    path:'/about', 
    name: 'about', 
    options: ['sitemap' => [
                'priority' => 0.7, 
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY]])]
    public function aboutAction(): Response
    {
        return $this->render('about.html.twig');
    }
}