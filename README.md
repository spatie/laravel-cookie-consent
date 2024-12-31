# Simple, customizable cookie consent message for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-cookie-consent.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-cookie-consent)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![run-tests](https://github.com/spatie/laravel-cookie-consent/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/laravel-cookie-consent/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-cookie-consent.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-cookie-consent)

This package adds a simple, customizable cookie consent message to your site. When the site loads, the banner appears and lets users consent to cookies. Once consent is given, the banner hides and stays hidden.

**What this package does not:**
- Include an option to 'Decline' all cookies, which might be required.
- Block trackers and cookies before consent. You need to handle this yourself.
- Include options for different consent categories like "Necessary" or "Marketing".

For more advanced cookie consent options in Laravel, consider these alternatives.

- [whitecube/laravel-cookie-consent](https://github.com/whitecube/laravel-cookie-consent)
- [statikbe/laravel-cookie-consent](https://github.com/statikbe/laravel-cookie-consent)

If you need an implementation of cookie consent for [Filament](https://github.com/filamentphp/filament) you can evaluate this plugin:

- [marcogermani87/filament-cookie-consent](https://github.com/marcogermani87/filament-cookie-consent)

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

In Laravel 11 open /bootstrap/app.php and register them there:

```php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\Spatie\CookieConsent\CookieConsentMiddleware::class);
    })
```

In Laravel 9 and 10 you can add them in app/Http/Kernel.php:

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
We are not lawyers and can't provide legal advice. Consult legal professionals what rules apply to your project.

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
