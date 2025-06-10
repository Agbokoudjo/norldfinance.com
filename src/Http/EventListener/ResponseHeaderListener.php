<?php

namespace App\Http\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class ResponseHeaderListener
{
    public function __invoke(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        // Supprime les en-têtes sensibles
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');
        $response->headers->remove('X-Turbo-Charged-By');

        // Ajoute ou modifie d'autres si besoin
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
    }
}
