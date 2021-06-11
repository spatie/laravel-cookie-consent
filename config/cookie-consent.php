<?php

return [

    /*
     * Use this setting to enable the cookie consent dialog.
     */
    'enabled' => env('COOKIE_CONSENT_ENABLED', true),

    /*
     * Use this setting to add a refuse button ont the dialog.
    */
    'refuse_enabled' => env('COOKIE_CONSENT_REFUSE_ENABLED', false),

    /*
     * The name of the cookie in which we store if the user
     * has agreed to accept the conditions.
     */
    'cookie_name' => 'laravel_cookie_consent',

    /*
     * Set the cookie duration in days.  Default is 365 * 20.
     */
    'cookie_lifetime' => 365 * 20,
];
