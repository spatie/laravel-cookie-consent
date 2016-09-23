<?php

namespace Spatie\CookieConsent\Test;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\CookieConsent\CookieConsentMiddleware;

class CookieConsentTest extends TestCase
{
    /** @test */
    public function it_provides_translations()
    {
        $this->assertTranslationExists('cookieConsent::texts.message');
        $this->assertTranslationExists('cookieConsent::texts.agree');
    }

    /** @test */
    public function it_can_display_a_cookie_consent_view()
    {
        $html = view('layout')->render();

        $this->assertConsentDialogDisplayed($html);
    }

    /** @test */
    public function it_will_not_show_the_cookie_consent_view_when_the_package_is_disabled()
    {
        $this->app['config']->set('laravel-cookie-consent.enabled', false);

        $html = view('layout')->render();

        $this->assertConsentDialogIsNotDisplayed($html);
    }

    /** @test */
    public function it_will_not_show_the_cookie_consent_view_when_the_user_has_already_consented()
    {
        $this->app['config']->set('laravel-cookie-consent.enabled', false);

        cookie(config('laravel-cookie-consent.cookie_name'), 1);

        $html = view('layout')->render();

        $this->assertConsentDialogIsNotDisplayed($html);
    }

    /** @test */
    public function it_injects_the_view_via_middleware()
    {
        $request = new Request();

        $middleware = new CookieConsentMiddleware($this->app);

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $this->assertContains('window.laravelCookieConsent', $result->getContent());
    }
}
