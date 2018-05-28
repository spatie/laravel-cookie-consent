# Make your Laravel app comply with the crazy EU cookie law

### Sponsor

<table>
   <tr>
      <td><img src="http://spatie.github.io/laravel-permission/sponsor-logo.png"></td>
      <td>If you want to quickly add secure token-based authentication to Laravel projects, feel free to check Auth0's Laravel SDK and free plan at <a href="https://auth0.com/overview?utm_source=GHsponsor&utm_medium=GHsponsor&utm_campaign=laravel-cookie-consent&utm_content=auth">https://auth0.com/overview</a>.</td>
   </tr>
</table>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-cookie-consent.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-cookie-consent)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-cookie-consent/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-cookie-consent)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/a3d7dae9-73fc-4a7d-9b6a-9a252233652c.svg?style=flat-square)](https://insight.sensiolabs.com/projects/a3d7dae9-73fc-4a7d-9b6a-9a252233652c)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-cookie-consent.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-cookie-consent)
[![StyleCI](https://styleci.io/repos/62055265/shield?branch=master)](https://styleci.io/repos/62055265)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-cookie-consent.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-cookie-consent)

All sites owned by EU citizens or targeted towards EU citizens must comply with a crazy EU law. This law requires a dialog to be displayed to inform the users of your websites how cookies are being used. You can read more info on the legislation on [the site of the European Commission](http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm#section_2).

This package provides an easily configurable view to display the message. Also included is JavaScript code to set a cookie when a user agrees with the cookie policy. The package will not display the dialog when that cookie has been set.

Spatie is a web design agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Installation

You can install the package via composer:

``` bash
composer require spatie/laravel-cookie-consent
```

The package will automatically register itself.

Optionally you can publish the config-file:

```bash
php artisan vendor:publish --provider="Spatie\CookieConsent\CookieConsentServiceProvider" --tag="config"
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

## Usage

To display the dialog all you have to do is include this view in your template:

```php
//in your blade template
@include('cookieConsent::index')
```

This will render the following dialog that, when styled, will look very much like this one.

![dialog](https://spatie.github.io/laravel-cookie-consent/images/dialog.png)
 
Please be aware that the package does not provide any styling, this is something you'll need to do yourself.

When the user clicks "Allow cookies" a `laravel_cookie_consent` cookie will be set and the dialog will be removed from the DOM. On the next request, Laravel will notice that the `laravel_cookie_consent` has been set and will not display the dialog again

## Customising the dialog texts

If you want to modify the text shown in the dialog you can publish the lang-files with this command:

```bash
php artisan vendor:publish --provider="Spatie\CookieConsent\CookieConsentServiceProvider" --tag="lang"
```

This will publish this file to `resources/lang/vendor/cookieConsent/en/texts.php`.

 ```php
 
 return [
     'message' => 'Please be informed that this site uses cookies.',
     'agree' => 'Allow cookies',
 ];
 ```
 
 If you want to translate the values to, for example, French, just copy that file over to `resources/lang/vendor/cookieConsent/fr/texts.php` and fill in the French translations.
 
### Customising the dialog contents

If you need full control over the contents of the dialog. You can publish the views of the package:

```bash
php artisan vendor:publish --provider="Spatie\CookieConsent\CookieConsentServiceProvider" --tag="views"
```

This will copy the `index` and `dialogContents` view files over to `resources/views/vendor/cookieConsent`. You probably only want to modify the `dialogContents` view. If you need to modify the JavaScript code of this package you can do so in the `index` view file.

## Using the middleware

Instead of including `cookieConsent::index` in your view you could opt to add the `Spatie\CookieConsent\CookieConsentMiddleware` to your kernel:

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

This will automatically add `cookieConsent::index` to the content of your response right before the closing body tag.

## Notice
The legislation is pretty very vague on how to display the warning, which texts are necessary, and what options you need to provide. This package will go a long way towards compliance, but if you want to be 100% sure that your website is ok, you should consult a legal expert.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [Willem Van Bockstal](https://github.com/willemvb)
- [All Contributors](../../contributors)

## Support us

Spatie is a web design agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
