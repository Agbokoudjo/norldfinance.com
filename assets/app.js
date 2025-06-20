import * as Turbo from "@hotwired/turbo"
import { appModule } from "./js/index.js"
appModule.__AOS.init({
    once: false,
    startEvent: 'DOMContentLoaded',
});
jQuery(window).on("load", () => {
    setTimeout(() => {
        appModule.__AOS.refresh();
    }, 500);
    appModule.initialize()
});
jQuery(function app() {
    window.NorldFinanceApp = appModule
    jQuery(document).on("turbo:load", () =>
        appModule.initialize()
    );
    jQuery(document).on('turbo:frame-load', () => appModule.initialize());
   // jQuery(this).on('turbo:visit', appModule.initialize())
    let resizeTimer;
    jQuery(window).on('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            appModule.toggleAOSOnElements();
        }, 250);
    });
    jQuery(document).on('turbo:click', (e) => { // Utilisez 'document' pour les événements globaux
        appModule.anchorElementHandler(e);
    });
    jQuery(document).on('initialize.owl.carousel', '.owl-carousel', function (event) {
        appModule.__AOS.refresh()
        appModule.__Logger.log(event)
    })
    jQuery(document).on('initialized.owl.carousel', '.owl-carousel', function (event) {
        appModule.__AOS.refresh()
        appModule.__Logger.log(event)
    })
    jQuery(document).on('change.owl.carousel', '.owl-carousel', function (event) {
        appModule.__AOS.refresh()
        appModule.__Logger.log(event)
    })
    jQuery(document).on('changed.owl.carousel', '.owl-carousel', function (event) {
        appModule.__AOS.refresh()
        appModule.__Logger.log(event)
    })
    jQuery(document).on('next.owl.carousel', function (event) {
        appModule.__AOS.refresh()
        appModule.__Logger.log(event)
    })
    Turbo.start();
})


function autoApplyTurboFrame(frameId = 'main_content') {
    // Gérer tous les liens <a>
    jQuery('a').each((index, elmt) => {
        const link = jQuery(elmt);
        const href = link.attr('href');
        console.log(href)
        if (
            !href ||
            href.startsWith('#') ||
            href.startsWith('mailto:') ||
            href.startsWith('tel:')
        ) {
            return;
        }

        const isExternal = href.startsWith('http') && !href.startsWith(window.location.origin);
        if (isExternal) return;

        if (/\.(pdf|zip|docx?|xlsx?|png|jpe?g|gif)$/i.test(href)) return;

        if (!link.attr('data-turbo-frame')) {
            link.attr('data-turbo-frame', frameId);
        }
    });
    // Gérer tous les formulaires <form>
    jQuery('form').each((index, elmt) => {
        const form = jQuery(elmt);
        const method = form.attr('method')?.toLowerCase() || 'get';
        const action = form.attr('action') || '';

        const isExternal = action.startsWith('http') && !action.startsWith(window.location.origin);
        if (isExternal || (method === 'post' && form.hasClass('no-turbo'))) {
            return;
        }

        if (!form.attr('data-turbo-frame')) {
            form.attr('data-turbo-frame', frameId);
        }
    });
}



 
  


