<?php
namespace App\Http\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class AboutController extends AbstractController{
    #[Route('/about',name:'about')]
    public function index():Response{
        return $this->render('about.html.twig');
    }
}