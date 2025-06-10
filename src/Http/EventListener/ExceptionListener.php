<?php

namespace App\Http\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\RouterInterface;

#[AsEventListener(event: ExceptionEvent::class, method: "onExceptionEvent")]
final class ExceptionListener
{
    public function __construct(private RouterInterface $router) {}

    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $isProd = ($_ENV['APP_ENV'] ?? 'prod') === 'prod';
        if (!$isProd) {
            return;
        }

        $exception = $event->getThrowable();
        $request = $event->getRequest();

        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $headers = [];

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $headers = $exception->getHeaders();
        }

        // Requête Ajax
        if ($request->isXmlHttpRequest()) {
            $event->setResponse(new JsonResponse([
                'message' => "Une erreur est survenue. Merci de réessayer plus tard.",
            ], $statusCode, $headers));
            return;
        }
        // Requête normale => redirection page d’accueil
        $event->setResponse(new RedirectResponse($this->router->generate('home')));
    }
}
