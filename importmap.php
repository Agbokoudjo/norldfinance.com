<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@hotwired/turbo' => [
        'version' => '8.0.18',
    ],
    'image-validator' => [
        'version' => '1.2.1',
    ],
    'papaparse' => [
        'version' => '5.5.3',
    ],
    'pdfjs-dist' => [
        'version' => '5.4.394',
    ],
    'xlsx' => [
        'version' => '0.18.5',
    ],
    'sweetalert2' => [
        'version' => '11.26.3',
    ],
    'animate.css' => [
        'version' => '4.1.1',
    ],
    'underscore' => [
        'version' => '1.13.7',
    ],
    'base64-js' => [
        'version' => '1.5.1',
    ],
    'jszip' => [
        'version' => '3.10.1',
    ],
    '@xmldom/xmldom' => [
        'version' => '0.8.11',
    ],
    '@xmldom/xmldom/lib/dom' => [
        'version' => '0.8.11',
    ],
    'xmlbuilder' => [
        'version' => '15.1.1',
    ],
    'dingbat-to-unicode' => [
        'version' => '1.0.1',
    ],
    'lop' => [
        'version' => '0.4.2',
    ],
    'animate.css/animate.min.css' => [
        'version' => '4.1.1',
        'type' => 'css',
    ],
    'option' => [
        'version' => '0.2.4',
    ],
    'libphonenumber-js' => [
        'version' => '1.12.26',
    ],
    'bootstrap' => [
        'version' => '5.3.8',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.8',
        'type' => 'css',
    ],
    'aos' => [
        'version' => '2.3.4',
    ],
    'owl.carousel' => [
        'version' => '2.3.4',
    ],
    'owl.carousel/dist/assets/owl.carousel.min.css' => [
        'version' => '2.3.4',
        'type' => 'css',
    ],
    'magnific-popup' => [
        'version' => '1.2.0',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'magnific-popup/dist/magnific-popup.min.css' => [
        'version' => '1.2.0',
        'type' => 'css',
    ],
    'select2' => [
        'version' => '4.1.0-rc.0',
    ],
    'select2/dist/css/select2.min.css' => [
        'version' => '4.1.0-rc.0',
        'type' => 'css',
    ],
    'lodash.throttle' => [
        'version' => '4.1.1',
    ],
    'lodash.debounce' => [
        'version' => '4.0.8',
    ],
    '@wlindabla/form_validator' => [
        'version' => '2.3.3',
    ],
];
