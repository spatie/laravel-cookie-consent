<?php

namespace Spatie\CookieConsent;

use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Cookie;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CookieConsentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-cookie-consent')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasViewComposer('cookie-consent::index', function (View $view) {
                $cookieConsentConfig = config('cookie-consent');

                $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);

                $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
            });
    }

    public function packageBooted(): void
    {
        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('cookie-consent.cookie_name'));
        });
    }
}
