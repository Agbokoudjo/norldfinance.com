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

namespace App\Http\EventListener\Seo;


use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\GoogleMultilangUrlDecorator;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
#[AsEventListener(event:SitemapPopulateEvent::class)]
final class SitemapGeneratorListener  
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly UrlGeneratorInterface $urlGenerator,
       private readonly ParameterBagInterface $params
    )
    {
        
    }
    public function __invoke(SitemapPopulateEvent $sitemapPopulateEvent):void
    {
        $urlContainerInterface=$sitemapPopulateEvent->getUrlContainer();
        /**
         * @var \ArrayIterator<Route>
         */
        $routesList=$this->router->getRouteCollection()->getIterator();
        /**
         * @var array|null
         */
        $supportedLocales=$this->params->get('locales');
        if(!$supportedLocales){return ;}
        while($routesList->valid()){
            /**
             * @var Route
             */
            $route=$routesList->current();
            /**
             * @var string
             */
            $routeName=$routesList->key();
            /**
             * @var  array<string ,mixed>
             */
            $options_route=$route->getOptions();
            if(!isset($options_route['sitemap'])){
                $routesList->next();
                continue;
            }

            foreach ($supportedLocales as $locale) {
                // Générer l'URL pour chaque langue
                try {
                    $url=$this->urlGenerator->generate($routeName, ['_locale' => $locale], UrlGeneratorInterface::ABSOLUTE_URL);
                } catch (\Exception $e) {
                    // En cas de route inaccessible pour cette locale (ex: erreur de paramètres), on saute
                    continue;
                }
                $decoratedUrlItem=new GoogleMultilangUrlDecorator(new UrlConcrete(
                    $url,
                    new \DateTime(),
                    $options_route['sitemap']['changefreq'] ?? UrlConcrete::CHANGEFREQ_WEEKLY,
                    $options_route['sitemap']['priority'] ?? 0.5
                ));
                // Ajouter les balises hreflang
                foreach ($supportedLocales as $altLocale) {
                    try{
                        $altUrlItem= $this->urlGenerator->generate($routeName, ['_locale' => $altLocale], UrlGeneratorInterface::ABSOLUTE_URL);
                        $decoratedUrlItem = $decoratedUrlItem->addLink($altUrlItem,$altLocale,$locale)   ;                
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                $urlContainerInterface->addUrl($decoratedUrlItem, 'sitemap_' . $locale);
            }
            $routesList->next();
        }

    }
}
