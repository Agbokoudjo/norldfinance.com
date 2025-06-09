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
        'version' => '8.0.13',
    ],
    'image-validator' => [
        'version' => '1.2.1',
    ],
    'papaparse' => [
        'version' => '5.5.3',
    ],
    'pdfjs-dist' => [
        'version' => '5.3.31',
    ],
    'xlsx' => [
        'version' => '0.18.5',
    ],
    'sweetalert2' => [
        'version' => '11.22.0',
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
        'version' => '0.9.8',
    ],
    '@xmldom/xmldom/lib/dom' => [
        'version' => '0.9.8',
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
        'version' => '1.12.9',
    ],
    '@wlindabla/form_validator' => [
        'version' => '1.3.7',
    ],
];
