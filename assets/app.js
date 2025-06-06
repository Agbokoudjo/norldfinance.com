import "./app.css";
import './styles/responsive.css'
import * as Turbo from "@hotwired/turbo"
import { Application,Controller } from '@hotwired/stimulus'
import {
    Logger, httpFetchHandler,
    HttpResponse, handleErrorsManyForm,
    HttpFetchError,
    addParamToUrl,
    mapStatusToResponseType,
    FieldValidationFailed, FormValidate,
    addHashToIds,FieldValidationSuccess,
    addErrorMessageFieldDom,
    clearErrorInput,
    FormFormattingEvent,
    configurePDFWorker,
    toBoolean
} from "@wlindabla/form_validator"
configurePDFWorker('https://cdn.jsdelivr.net/npm/pdfjs-dist@5.2.133/build/pdf.worker.min.mjs')
import {config} from "./js/index.js"
const application = Application.start()
application.register("example", class tubrno extends Controller {
  connect() {
    Logger.log("Controller connecté après navigation Turbo")
  }
})
const logger = Logger.getInstance();
logger.APP_ENV = "prod";
logger.DEBUG = false;
Logger.log(application)
Logger.log(Turbo)
jQuery(document).on("load", initialize);
jQuery(document).on("turbo:load", initialize);
jQuery(document).on('turbo:frame-load', initialize);
jQuery(document).on('turbo:visit', initialize)
jQuery(document).on('turbo:click', (e) => {
  const anchorElement = e.target.closest('a');
  if (!anchorElement) return;

  const isSamePageAnchor =
    anchorElement.hash &&
    anchorElement.origin === window.location.origin &&
    anchorElement.pathname === window.location.pathname;

  if (isSamePageAnchor) {
    e.preventDefault(); // empêche Turbo de gérer le clic
    history.pushState({}, '', anchorElement.href); // mise à jour manuelle de l'URL
    window.dispatchEvent(new Event('hashchange')); // déclenche l'événement hashchange
  }
});

function initialize() {
    initOwlCarousel();
    initMagnificPopup();
    initCounters();
    toggleAOSOnElements();
    AOS.refresh();
    formSubmitHander();
    formValidator();
    setup_select2();
    updateCheckbox();
    formFormattingEvent();
    disableUserInteractions();
    Turbo.start();
    Logger.log(Turbo.session.drive); // true attendu
    //Turbo.session.preloadOnHover = false;
}
function updateCheckbox(){
    jQuery('input[type="checkbox"]').each((index, elmt) => {
        const input=jQuery(elmt)
        const container_parent = input.closest('div.form-check')
        container_parent.addClass('form-switch');
    })
}
    // Fonction pour activer/désactiver AOS
function toggleAOSOnElements() {
    // Définir la largeur à partir de laquelle nous considérons un "desktop"
    // Bootstrap utilise 992px pour 'lg' (large devices) et plus.
    // Vous pouvez ajuster cette valeur si vos breakpoints sont différents.
const desktopBreakpoint = 992; // Correspond à la rupture 'lg' de Bootstrap
        const windowWidth = $(window).width();

        // Sélecteurs pour les éléments dont les attributs AOS doivent être gérés
        // Cible tous les éléments DANS ces conteneurs qui ont un attribut data-aos
        const elementsToManage = $(".whatsapp-parent, .creator-credit-parent [data-aos]");
        // Remarque : Si le bouton WhatsApp est position: fixed, son parent col-md-6 n'a pas vraiment d'impact.
        // Si vous voulez aussi enlever l'animation sur le "col-md-6" du bouton, ciblez-le explicitement.
        // Exemple: $(".whatsapp-parent [data-aos], .creator-credit-parent [data-aos]");

        if (windowWidth >= desktopBreakpoint) {
            // C'est un ordinateur de bureau (desktop)
            elementsToManage.each(function() {
                const $this = $(this);
                // Stocker les attributs AOS dans des attributs data-* personnalisés avant de les retirer
                if ($this.attr('data-aos')) {
                    $this.attr('data-aos-temp', $this.attr('data-aos'));
                    $this.removeAttr('data-aos');
                }
                if ($this.attr('data-aos-duration')) {
                    $this.attr('data-aos-duration-temp', $this.attr('data-aos-duration'));
                    $this.removeAttr('data-aos-duration');
                }
                if ($this.attr('data-aos-delay')) {
                    $this.attr('data-aos-delay-temp', $this.attr('data-aos-delay'));
                    $this.removeAttr('data-aos-delay');
                }
                // Optionnel: Réinitialiser les styles AOS s'ils ont été appliqués (opacity: 0, etc.)
                // Ceci est crucial si les éléments étaient déjà cachés par AOS
                $this.css({
                    'opacity': '1',
                    'transform': 'none',
                    'transition': 'none',
                    'pointer-events': 'auto',
                    'visibility': 'visible'
                });
            });
            // Désactiver AOS complètement si vous voulez être sûr qu'il n'interfère pas
            // (AOS désactive certaines de ses fonctionnalités de détection de scroll)
            // Mais la désactivation par élément est plus précise ici.
        } else {
            // C'est un mobile, iPhone, Android, tablette (proche du mobile)
            elementsToManage.each(function() {
                const $this = $(this);
                // Restaurer les attributs AOS si stockés
                if ($this.attr('data-aos-temp')) {
                    $this.attr('data-aos', $this.attr('data-aos-temp'));
                    $this.removeAttr('data-aos-temp');
                }
                if ($this.attr('data-aos-duration-temp')) {
                    $this.attr('data-aos-duration', $this.attr('data-aos-duration-temp'));
                    $this.removeAttr('data-aos-duration-temp');
                }
                if ($this.attr('data-aos-delay-temp')) {
                    $this.attr('data-aos-delay', $this.attr('data-aos-delay-temp'));
                    $this.removeAttr('data-aos-delay-temp');
                }
                // Réinitialiser les styles AOS s'ils ont été appliqués par le script de désactivation
                // AOS prendra le relais et définira l'opacité à 0 si l'élément n'est pas encore visible.
                $this.css({
                    'opacity': '', // Remet la valeur par défaut
                    'transform': '',
                    'transition': '',
                    'pointer-events': '',
                    'visibility': ''
                });
            });
            // Important : relancer AOS après avoir restauré les attributs
            AOS.refresh();
        }
}
function initCounters() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.7
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            animateCounter(entry, observer);
        });
    }, observerOptions);

    jQuery('.counter-up').each(function () {
        observer.observe(this);
    });
}

function animateCounter(entry, observer) {
    if (entry.isIntersecting) {
        const $counterElement = jQuery(entry.target);
        const targetCount = parseInt($counterElement.data('count'), 10);
        let currentCount = 0;
        const duration = 1200;
        const incrementTime = 10;
        const step = (targetCount / duration) * incrementTime;

        const timer = setInterval(() => {
            currentCount += step;
            if (currentCount >= targetCount) {
                $counterElement.text(targetCount);
                clearInterval(timer);
                observer.unobserve(entry.target);
            } else {
                $counterElement.text(Math.floor(currentCount));
            }
        }, incrementTime);
    }
}
function initMagnificPopup() {
    jQuery('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        iframe: {
            patterns: {
                mp4: {
                    index: 'public/assets/video/',
                    src: '%id%'
                }
            }
        }
    });
}
function initOwlCarousel() {
    jQuery(".owl-carousel.hero-slider").owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplayHoverPause: true,
        nav: false,
        dots: false,
        animateOut: 'fadeOut',
    });
}
let resizeTimer;
jQuery(window).on('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        toggleAOSOnElements();
    }, 250);
});
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
function formValidator() {
    const form_exist = document.querySelector('form.form-validator');
    if (form_exist ===null) {
        return;
    }
    /**
     * @var {FormValidate}
     */
    let formValidate;
    try{
        formValidate = new FormValidate('.form-validator');
    } catch (error) {
        Logger.error('formValidate:', error);
        return;
    }
    const form_current = formValidate.form;
    const $submitButton = jQuery('button[type="submit"]', form_current);
     const idsBlur = addHashToIds(formValidate.idChildrenUsingEventBlur).join(",");
    const idsInput = addHashToIds(formValidate.idChildrenUsingEventInput).join(",");
      const idsChange = addHashToIds(formValidate.idChildrenUsingEventChange).join(",");
     form_current.on("blur", `${idsBlur}`, async (event) => {
    const target = event.target;
    if (target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement) {
        await formValidate.validateChildrenForm(event.target)
    }
         Logger.log(event);
     })
    form_current.on(FieldValidationFailed, (event) => {
        event.preventDefault();
        event.stopPropagation();
        const data = (event.originalEvent).detail;
        Logger.error('failled',data);
        addErrorMessageFieldDom(jQuery(data.targetChildrenForm), data.message)
        if (data.message.lenght !==0) {
            $submitButton.prop('disabled', true);
        }
    })
    form_current.on(FieldValidationSuccess, (event) => {
         event.preventDefault();
        event.stopPropagation();
        const data = (event.originalEvent).detail;
        Logger.log('success validate',data);
        $submitButton.removeAttr('disabled');
    })
    form_current.on('input', `${idsInput}`, (event) => {
        const target = event.target;
        if (target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement) {
            if (jQuery(target).val()) {
                clearErrorInput(jQuery(target))
                formValidate.clearErrorDataChildren(target)
            }
        }
        $submitButton.removeAttr('disabled');
         Logger.log(target);
    })
    form_current.on('change', `${idsChange}`, (event) => {
    const target = event.target;
    if (target instanceof HTMLInputElement) {
      if (target) {
        clearErrorInput(jQuery(target))
        formValidate.clearErrorDataChildren(target)
      }
    }
    Logger.log(event);
  });
}
function formSubmitHander() {
    /**
     * @var {string}
     */
    let originalText;
    jQuery(document).on('submit', 'form.form-validator', async (event) => {
        event.preventDefault();
         event.stopPropagation();
        const form = jQuery(event.target);
        const $submitButton = jQuery('button[type="submit"]', form);
        originalText = $submitButton.text();
        $submitButton.prop('disabled', true);
        $submitButton.text('Envoi en cours...');

        let timerInterval;
        Swal.fire({
            title: 'Traitement',
            icon: 'info',
            html: `<div class="alert alert-info" role="alert">
                    Transmission des données en cours. Merci de votre patience.
                </div>`,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            background: "#00427E",
            color: "#fff",
            timer: 60000,
            timerProgressBar: true,
            didOpen: () => {
                document.querySelector('.swal2-container').style.zIndex = '99999';
                Swal.showLoading();
                const timerElement = Swal.getPopup()?.querySelector("b");
                timerInterval = setInterval(() => {
                    if (timerElement) {
                        timerElement.textContent = `${Swal.getTimerLeft()}ms`;
                    }
                }, 100);
            },
            willClose: () => clearInterval(timerInterval),
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            },
           customClass:{
                loader: 'spinner-border text-info',
                timerProgressBar:"bg-info"
            }
        });
        try {
            const response_data = await httpFetchHandler({
                url: addParamToUrl(window.location.href, { contact_form: true }),
                data: new FormData(form.get()[0]),
                methodSend: form.attr('method')?.toUpperCase() || "POST",
                timeout:60000,
                retryCount:2,
                responseType: "json"
            });

            if (mapStatusToResponseType(response_data.status) === "error") {
                throw response_data;
            }

            const data = response_data.data;
            Swal.close();
            Swal.fire({
                title: data.title,
                icon: "success",
                html: `<div class="alert alert-success" role="alert">${data.message}</div>`,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 40000,
                showConfirmButton: false,
                ...baseSweetAlert2Options,
                  showCloseButton: true
            });
            form.get()[0].reset();
            $submitButton.text(originalText);
        } catch (error) {
            Logger.error('fetch result error',error)
            console.error('fetch result error',error)
            if (error instanceof HttpResponse) {
                const errors_data = error.data;
                let message = "une erreur s'est produite";
                let title="Erreur"
                if (error.status === 422) {
                    message = errors_data.details;
                    title = errors_data.title;
                    handleErrorsManyForm(
                        form.attr('name') || '',
                        form.attr('id') || '',
                        errors_data.violations || {}
                    );
                }
                else if (error.status === 404) {
                    message =data;
                    title = `Erreur 404 : Page introuvable pour Url ${window.location.href}`;
                }
                else {
                    message = errors_data;
                }
                Swal.close();
                Swal.fire({
                        title: title,
                        icon: "error",
                        html: `<div class="alert alert-danger" role="alert">${message}</div>`,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                         showCloseButton: true,
                        ...baseSweetAlert2Options
                    });
            }

            if (error instanceof HttpFetchError) {
                Swal.close();
                Swal.fire({
                    title: "Erreur réseau",
                    icon: "error",
                    html: `<div class="alert alert-danger" role="alert">${error.message}</div>`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    ...baseSweetAlert2Options,
                     showCloseButton: true
                });
            }
            originalText="Réessayer"
        } finally {
            Logger.log(originalText)
            $submitButton.prop('disabled', false);
            $submitButton.removeAttr('disabled');
            return;
        }
    });
}
/**
 * @SweetAlert2Options
 */
export const baseSweetAlert2Options = {
    animation: true,
    allowEscapeKey: false,
    background: "#00427E",
    color: "#fff",
    didOpen: () => {
        document.querySelector('.swal2-container').style.zIndex = '99999';
    },
    showClass: {
        popup: `
                animate__animated
                animate__fadeInUp
                animate__faster
                `
    },
    hideClass: {
        popup: `
                animate__animated
                animate__fadeOutDown
                animate__faster
                `
    }
}
function setup_select2() {

      jQuery('select:not([data-sonata-select2="false"])',document).each((index, element) => {
        const select = jQuery(element);
        let allowClearEnabled = false;
        const popover = select.data('popover');
        let maximumSelectionLength = null;
        let minimumResultsForSearch = 10;
        let allowTags = false;

        select.removeClass('form-control');

        if (
          select.find('option[value=""]').length ||
          (select.attr('data-placeholder') && select.attr('data-placeholder').length) ||
          select.attr('data-sonata-select2-allow-clear') === 'true'
        ) {
          allowClearEnabled = true;
        } else if (select.attr('data-sonata-select2-allow-clear') === 'false') {
          allowClearEnabled = false;
        }

        if (select.attr('data-sonata-select2-allow-tags') === 'true') {
          allowTags = true;
        }

        if (select.attr('data-sonata-select2-maximumSelectionLength')) {
          maximumSelectionLength = select.attr('data-sonata-select2-maximumSelectionLength');
        }

        if (select.attr('data-sonata-select2-minimumResultsForSearch')) {
          minimumResultsForSearch = select.attr('data-sonata-select2-minimumResultsForSearch');
        }

        select.select2({
            width: () => get_select2_width(select),
          dropdownAutoWidth: true,
          minimumResultsForSearch,
          placeholder: allowClearEnabled ? ' ' : '', // allowClear needs placeholder to work properly
          allowClear: allowClearEnabled,
          maximumSelectionLength,
            tags: allowTags,
           theme: "bootstrap-5",
        });

        if (undefined !== popover) {
          select.select2('container').popover(popover.options);
        }
      });
}
  /** Return the width for simple and sortable select2 element * */
function get_select2_width(element) {
    const ereg = /width:(auto|(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc)))/i;

    // this code is an adaptation of select2 code (initContainerWidth function)
    let style = element.attr('style');
    // console.log("main style", style);

    if (style !== undefined) {
      const attrs = style.split(';');

      for (let i = 0, l = attrs.length; i < l; i += 1) {
        const matches = attrs[i].replace(/\s/g, '').match(ereg);
        if (matches !== null && matches.length >= 1) return matches[1];
      }
    }

    style = element.css('width');
    if (style.indexOf('%') > 0) {
      return style;
    }

    return '100%';
  }
  
function formFormattingEvent(){
    const formFormattingEvent = FormFormattingEvent.getInstance();
    const lang = jQuery('html', document).attr('lang') ?? "fr";
    formFormattingEvent.init(document," "," ",{locales:lang})
  }

function disableUserInteractions() { 
    if (toBoolean(config.param('DEBUG')) && config.param('APP_ENV') === "dev") { return; }
  jQuery(document).on('contextmenu', function(e) {
        e.preventDefault(); // Empêche le comportement par défaut du clic droit
    });
    jQuery(document).on('keydown', function(e) {
        // e.which est l'équivalent de e.keyCode en jQuery, mieux supporté sur les anciens navigateurs
        if (e.which === 123 || // F12
            (e.ctrlKey && e.shiftKey && e.which === 73) || // Ctrl+Shift+I
            (e.ctrlKey && e.shiftKey && e.which === 74) || // Ctrl+Shift+J
            (e.ctrlKey && e.which === 85) // Ctrl+U
        ) {
            e.preventDefault();
        }
    });
}
