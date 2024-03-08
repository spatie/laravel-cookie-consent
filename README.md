# Make your Laravel app comply with the crazy EU cookie law

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-cookie-consent.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-cookie-consent)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![run-tests](https://github.com/spatie/laravel-cookie-consent/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/laravel-cookie-consent/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-cookie-consent.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-cookie-consent)

All sites owned by EU citizens or targeted towards EU citizens must comply with a crazy EU law. This law requires a dialog to be displayed to inform the users when you are using _tracking_ cookies. You can read more info on the legislation on [the site of the European Commission](https://commission.europa.eu/resources-partners/europa-web-guide/design-content-and-development/privacy-security-and-legal-notices/cookies-and-similar-technologies_en). Be aware using cookies for a site/web app that is not used for tracking (for example: session cookies) do not fall under this obligation 

quote:
```
Cookies and similar technologies requiring consent

Cookies and similar technologies that generally DO need consent

    Social plug-in tracking mechanisms
    Third party advertising cookies
    Analytics cookies (except for the exemption described further below)

Cookies and similar technologies that generally do NOT need consent

    User entrada cookies, for the duration of a session
    Authentication cookies, for the duration of a session
    User centric security cookies, used to detect authentication abuses and linked to the functionality explicitly requested by the user, for a limited persistent duration
    Multimedia content player session cookies, such as flash player cookies, for the duration of a session
    Load balancing session cookies, for the duration of a session
    User interface customisation cookies, for a browser session or a pocos hours, unless additional information in a prominent location is provided (e.g. “uses cookies” written next to the customisation feature)
```
    
This package provides an easily configurable view to display the message. Also included is JavaScript code to set a cookie when a user agrees with the cookie policy. The package will not display the dialog when that cookie has been set.

Spatie is a web design agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-cookie-consent.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-cookie-consent)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

``` bash
composer require spatie/laravel-cookie-consent
```

The package will automatically register itself.

Optionally you can publish the config-file:

```bash
php artisan vendor:publish --provider="Spatie\CookieConsent\CookieConsentServiceProvider" --tag="cookie-consent-config"
```

This is the contents of the published config-file:

```php
return [

    /*
     * Use this setting to enable the cookie consent dialog.
     */
    'enabled' => env('COOKIE_CONSENT_ENABLED', true),

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
```

The cookie domain is set by the 'domain' key in config/session.php, make sure you add a value in your .env for SESSION_DOMAIN. If you are using a domain with a port in the url such as 'localhost:3000', this package will not work until you do so.

## Usage

To display the dialog all you have to do is include this view in your template:

```blade
//in your blade template
@include('cookie-consent::index')
```

This will render the following dialog that, when styled, will look very much like this one.

![dialog](https://spatie.github.io/laravel-cookie-consent/images/dialog.png)

The default styling provided by this package uses TailwindCSS v2 to provide a floating banner at the bottom of the page.

When the user clicks "Allow cookies" a `laravel_cookie_consent` cookie will be set and the dialog will be removed from the DOM. On the next request, Laravel will notice that the `laravel_cookie_consent` has been set and will not display the dialog again

## Customising the dialog texts

If you want to modify the text shown in the dialog you can publish the lang-files with this command:

```bash
php artisan vendor:publish --provider="Spatie\CookieConsent\CookieConsentServiceProvider" --tag="cookie-consent-translations"
```

This will publish this file to `resources/lang/vendor/cookie-consent/en/texts.php`.

 ```php
 
 return [
     'message' => 'Please be informed that this site uses cookies.',
     'agree' => 'Allow cookies',
 ];
 ```
 
 If you want to translate the values to, for example, French, just copy that file over to `resources/lang/vendor/cookie-consent/fr/texts.php` and fill in the French translations.
 
### Customising the dialog contents

If you need full control over the contents of the dialog. You can publish the views of the package:

```bash
php artisan vendor:publish --provider="Spatie\CookieConsent\CookieConsentServiceProvider" --tag="cookie-consent-views"
```

This will copy the `index` and `dialogContents` view files over to `resources/views/vendor/cookie-consent`. You probably only want to modify the `dialogContents` view. If you need to modify the JavaScript code of this package you can do so in the `index` view file.

## Using the middleware

Instead of including `cookie-consent::index` in your view you could opt to add the `Spatie\CookieConsent\CookieConsentMiddleware` to your kernel:

```php
// app/Http/Kernel.php

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...
        \Spatie\CookieConsent\CookieConsentMiddleware::class,
    ];

    // ...
}
```

This will automatically add `cookie-consent::index` to the content of your response right before the closing body tag.

## Notice
The legislation is pretty very vague on how to display the warning, which texts are necessary, and what options you need to provide. This package will go a long way towards compliance, but if you want to be 100% sure that your website is ok, you should consult a legal expert.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [Willem Van Bockstal](https://github.com/willemvb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
