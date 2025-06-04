<?php
namespace App\Http\EventSubscriber;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;
class RequestContextSubscriber implements EventSubscriberInterface{
    public function __construct(private readonly Environment $twig)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $isAjax = $request->isXmlHttpRequest();
        $isTurbo = $request->headers->has('Turbo-Frame') ||
                 $request->headers->has('Turbo-Stream');
        $this->twig->addGlobal('is_partial_request', $isAjax || $isTurbo);
    }
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 0],
        ];
    }
}