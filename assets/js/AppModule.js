import  AOS from "aos";
import jQuery from "../vendor/jquery/jquery.index.js";
import Swal from "sweetalert2"
window.jQuery = window.$ = jQuery;
import {
    Logger, 
    handleErrorsManyForm,
    addHashToIds,FieldValidationSuccess,
     FormValidateController,
    addHashToIds,
    FieldValidationFailed,
    addErrorMessageFieldDom,
    clearErrorInput,
   formatterEvent 
} from "@wlindabla/form_validator";
import config from "./_config.js"
import { translation } from "./index.js";
window.jQuery = window.$ = jQuery;
const logger = Logger.getInstance();
logger.APP_ENV = config.param('APP_ENV');
logger.DEBUG = config.param('DEBUG');
/**
 * @type {SweetAlert2Options}
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

export class AppModule {
    /**
     * Instance unique du module (singleton).
     * @type {AppModule | null}
     * @private
     * @static
     */
    static #app_module = null;
    constructor()
     {
         Logger.log('AppModule initializer:',this);
    }
    /**
     * Récupère l'instance unique de AppModule.
     * @returns {AppModule}
     */
    static getInstance() {
        if (!AppModule.#app_module) { AppModule.#app_module = new AppModule(); }
        return AppModule.#app_module;
    }
    initialize() {

         // Console log pour vérifier que la fonction est bien appelée
        Logger.log("AppModule.initialize():","AppModule.initialize() called due to Turbo/Load event.");
        console.log("AppModule.initialize():","AppModule.initialize() called due to Turbo/Load event.")
        this.bootstrapHandler();
        this.initOwlCarousel();
        this.initMagnificPopup();
        this.initCounters();
        this.toggleAOSOnElements();
        this.formSubmitHander();
        this.formValidator();
        this.setup_select2();
        this.updateCheckbox();
        this.formFormattingEvent();
        AOS.refresh();
        this.disableUserInteractions();
        window.jQuery = window.$ = jQuery;
        Logger.log('jQuery version:', window.jQuery?.fn?.jquery);
    }
    bootstrapHandler() {
        if (typeof bootstrap !== 'undefined') {
        // 1. Initialisation des dropdowns
        const dropdownToggleList = jQuery('[data-bs-toggle="dropdown"]');
        dropdownToggleList.each(function (_, dropdownToggleEl) {
            new bootstrap.Dropdown(dropdownToggleEl);
        });
    
        // 2. Initialisation des éléments collapsibles
        const collapseToggleList = jQuery('[data-bs-toggle="collapse"]');
        collapseToggleList.each(function (_, collapseToggleEl) {
            new bootstrap.Collapse(collapseToggleEl, {
                toggle: false // Empêche l'ouverture automatique
            });
        });
    
        // 3. Initialisation des tooltips (infobulles)
        const tooltipTriggerList = jQuery('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.each(function (_, tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    
        // 4. Initialisation des popovers
        const popoverTriggerList = jQuery('[data-bs-toggle="popover"]');
        popoverTriggerList.each(function (_, popoverTriggerEl) {
            new bootstrap.Popover(popoverTriggerEl);
        });
    } else {
    Logger.warn("Bootstrap object not found. Make sure Bootstrap CDN is loaded before your custom script.");
    }
    }
    
    updateCheckbox(){
        jQuery('input[type="checkbox"]').each((index, elmt) => {
            const input=jQuery(elmt)
            const container_parent = input.closest('div.form-check')
            container_parent.addClass('form-switch');
        })
    }
    toggleAOSOnElements() {
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
    get __AOS(){return AOS}
    get __Logger(){return Logger }
    initCounters=()=> {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.7
        };
    
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                this.#animateCounter(entry, observer);
            });
        }, observerOptions);
    
        jQuery('.counter-up').each(function () {
            observer.observe(this);
        });
    }
    #animateCounter(entry, observer) {
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
    initMagnificPopup() {
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
    initOwlCarousel() {
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
    /**
     * 
     * @param {boolean} DEBUG 
     * @param {string} APP_ENV 
     * @returns 
     */
    disableUserInteractions() {
        if (config.param('DEBUG') ===true && config.param('APP_ENV') === "dev") { return; }
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
    formValidator() {
         const form_exist = document.querySelector('form.form-validate');
        if (form_exist ===null) {
            return;
        }
        
    const form_validate = new FormValidateController('.form-validate');
    const __form = form_validate.form;

    const idsBlur = addHashToIds(form_validate.idChildrenUsingEventBlur).join(",");
    const idsInput = addHashToIds(form_validate.idChildrenUsingEventInput).join(",");
    const idsChange = addHashToIds(form_validate.idChildrenUsingEventChange).join(",");

    __form.on("blur", `${idsBlur}`, async (event) => {
        const target = event.target;
        if ((target instanceof HTMLInputElement ||
            target instanceof HTMLTextAreaElement)
           && target.type !== "file") {

            await form_validate.validateChildrenForm(target);
        }
    });

    __form.on(FieldValidationFailed, (event) => {
        const data = (event.originalEvent).detail;

        addErrorMessageFieldDom(jQuery(data.targetChildrenForm), data.message,'container-div-error-message');
    });

    __form.on('input', `${idsInput}`, (event) => {
        const target = event.target;
        if ((target instanceof HTMLInputElement ||
            target instanceof HTMLTextAreaElement)
             && target.type !== "file") {

            clearErrorInput(jQuery(target));
        }
    });
    __form.on('change', `${idsChange}`, async (event) => {
         const target = event.target;
        if (target instanceof HTMLInputElement && target.type === "file") {

            await form_validate.validateChildrenForm(target);
        }
    })
    __form.on('dragenter',`${idsChange}`, (event) => {
        const target = event.target;
        if (target instanceof HTMLInputElement && target.type === "file") {

            clearErrorInput(jQuery(target));
        }
    });
    __form.on(FieldValidationSuccess, (event) => {
             event.preventDefault();
            
            const data = (event.originalEvent).detail;
            Logger.log('success validate',data);
            $submitButton.removeAttr('disabled');
        })
    }

    formSubmitHander() {
        this.initializeTurboFormHandler();
    }


    /**
     * Fonction principale qui initialise les écouteurs d'événements Turbo.
     */
    initializeTurboFormHandler() {
    
         /**
         * @var {Map<HTMLFormElement,string>}
         */
        let originalButtonTexts=new Map();
        // =================================================================
        // 1. ÉVÉNEMENT DE DÉPART (turbo:submit-start) : Gestion du Chargement
        // =================================================================
        jQuery(document).on('turbo:submit-start', 'form.form-validator', function (event) {
            const $form = jQuery(this);
            const $submitButton = $form.find('button[type="submit"]');
            if ($submitButton.length) {
                // Stocke le texte original du bouton
                originalButtonTexts.set($form[0], $submitButton.text());

                // Désactive le bouton et met le texte de chargement
                $submitButton.prop('disabled', true);
                // NOTE: Assurez-vous que 'translation.trans("submitButton")' est la bonne traduction pour "Envoi en cours..."
                $submitButton.text(translation.trans("submitButton")); 
            }
        
            // Affiche votre SweetAlert de "Message avant l'envoi des données"
            let timerInterval;
            Swal.fire({
                title: translation.trans("messageBeforeSendData_title"),
                icon: 'info',
                html: `<div class="alert alert-info" role="alert">
                        ${translation.trans("messageBeforeSendData_content")}
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
         });


        // =================================================================
        // 2. ÉVÉNEMENT DE FIN (turbo:submit-end) : Gestion de la Réponse JSON
        // =================================================================
        jQuery(document).on('turbo:submit-end', 'form.form-validator', async function (event) {
            const $form = jQuery(this);
            const formElement = $form[0];
            const $submitButton = $form.find('button[type="submit"]');
            const fetchResponse = event.detail.fetchResponse;
            console.log(event.detail)
            // Ferme le SweetAlert de chargement
            Swal.close();
            
            // --- Réactivation du bouton ---
            if ($submitButton.length) {
                $submitButton.prop('disabled', false);
                const originalText = originalButtonTexts.get(formElement);
                if (originalText) {
                    $submitButton.text(originalText);
                    originalButtonTexts.delete(formElement);
                }
            }

        // --- Vérification et traitement de la réponse ---
        if (!fetchResponse || !fetchResponse.response) {
             // Erreur réseau ou avant la réponse
             Swal.fire({
                 title: "Erreur réseau",
                 icon: "error",
                 html: `<div class="alert alert-danger" role="alert">Erreur de connexion ou timeout.</div>`,
                 ...baseSweetAlert2Options, showCloseButton: true
             });
             return;
        }

        try {
            const responseStatus = fetchResponse.response.status;
            // Tente de lire la réponse JSON
            const data = await fetchResponse.response.json();
            
            if (responseStatus === 201) {
                // --- CAS DU SUCCÈS (HTTP 201 Created) ---
                
                Swal.fire({
                    title: data.title,
                    icon: "success",
                    html: `<div class="alert alert-success" role="alert">${data.message}</div>`,
                    timer: 40000,
                    showConfirmButton: false,
                    ...baseSweetAlert2Options,
                    showCloseButton: true
                });
                // Réinitialise le formulaire
                formElement.reset();
                
            } else if (responseStatus === 422) {
                // --- CAS DES ERREURS DE VALIDATION (HTTP 422 Unprocessable Entity) ---
                
                Swal.fire({
                    title: data.title,
                    icon: "error",
                    html: `<div class="alert alert-danger" role="alert">${data.details}</div>`,
                    showConfirmButton: false,
                    showCloseButton: true,
                    ...baseSweetAlert2Options
                });

                // Affiche les erreurs spécifiques à chaque champ
                handleErrorsManyForm(
                    data.formName || $form.attr('name') || '',
                    $form.attr('id') || '',
                    data.violations || {}  
                );
                
            } else {
                // --- AUTRES ERREURS HTTP (404, 500, etc.) ---
                Swal.fire({
                    title: `Erreur ${responseStatus}`,
                    icon: "error",
                    html: `<div class="alert alert-danger" role="alert">Le serveur a retourné une erreur inattendue.</div>`,
                    showConfirmButton: false,
                    showCloseButton: true,
                    ...baseSweetAlert2Options
                });
            }

        } catch (error) {
            // Erreur de parsing JSON ou autre problème de promesse
            Swal.fire({
                title: "Erreur de traitement",
                icon: "error",
                html: `<div class="alert alert-danger" role="alert">Impossible de lire la réponse du serveur (JSON invalide).</div>`,
                showConfirmButton: false,
                showCloseButton: true,
                ...baseSweetAlert2Options
            });
        }
    });
}

    setup_select2=()=> {
        jQuery('select:not([data-sonata-select2="false"])', document).each((index, element) => {
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
                width: () => this.get_select2_width(select),
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
    get_select2_width(element) {
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
  formFormattingEvent(){
    formatterEvent.lastnameToUpperCase(document);
    formatterEvent.capitalizeUsername(document);
    formatterEvent.usernameFormatDom(document);
  }
 /**
  * @param {Event} e 
  * @returns 
  */
  anchorElementHandler(e) {
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
  }
}

const instance = AppModule.getInstance();
export default instance;
