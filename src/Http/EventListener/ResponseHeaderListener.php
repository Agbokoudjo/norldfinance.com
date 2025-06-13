<?php
/*
 * This file is part of the project by AGBOKOUDJO Franck.
 *
 * (c) AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * Phone: +229 0167 25 18 86
 * LinkedIn: https://www.linkedin.com/in/internationales-web-services-120520193/
 * Github: https://github.com/Agbokoudjo/norldfinance.com
 * Company: INTERNATIONALES WEB SERVICES
 *
 * For more information, please feel free to contact the author.
 */

namespace App\Http\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
#[AsEventListener]
class ResponseHeaderListener
{
    public function __invoke(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        // Ajoute ou modifie d'autres si besoin
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Turbo-Charged-By', 'INTERNATIONALES WEB SERVICES');
        $response->headers->set('Server','INTERNATIONALES WEB SERVICES SERVER');
        $response->headers->set('X-Powered-By', '+229 0167251886');
    }
}
