<?php

namespace Spatie\CookieConsent;

use Cookie;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\ServiceProvider;

class CookieConsentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-cookie-consent.php' => config_path('laravel-cookie-consent.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/cookieConsent'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../resources/lang' => base_path('resources/lang/vendor/cookieConsent'),
        ], 'lang');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cookieConsent');

        $this->mergeConfigFrom(__DIR__.'/../config/laravel-cookie-consent.php', 'laravel-cookie-consent');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cookieConsent');

        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('laravel-cookie-consent.cookie_name'));
        });

        $this->app['view']->composer('cookieConsent::index', function (View $view) {
            $cookieConsentConfig = config('laravel-cookie-consent');

            $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);

            $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
