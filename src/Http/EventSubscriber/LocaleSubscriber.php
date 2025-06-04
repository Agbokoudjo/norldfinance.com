<?php
// src/EventSubscriber/LocaleSubscriber.php
namespace App\Http\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LocaleSwitcher $localeSwitcher
    ) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        $request = $event->getRequest();
        $locale = $request->getSession()->get('_locale', $request->getDefaultLocale()) ;
        $request->setLocale($locale);
        $request->getSession()->set('_locale', $locale);
        $this->localeSwitcher->setLocale($locale);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}