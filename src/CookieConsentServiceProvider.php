<?php

namespace Spatie\CookieConsent;

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

        $this->loadViewsFrom(__DIR__.'/resources/views', 'cookieConsent');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/laravel-cookie-consent'),
        ], 'views');

        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('laravel-cookie-consent.cookie_name'));
        });



        $this->app['view']->composer('cookieConsent::cookie-comply', function(View $view) {

            $cookieConsentConfig = config('laravel-cookie-consent');

            EncryptCookies::disableFor($cookieConsentConfig['cookie_name']);

            $alreadyAgreedWithCookies = $this->app['cookie']->has($cookieConsentConfig['cookie_name']);

            $view->with(compact('alreadyAgreedWithCookies', 'cookieConsentConfig'));
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-cookie-consent.php', 'cookieConsent');
    }
}
