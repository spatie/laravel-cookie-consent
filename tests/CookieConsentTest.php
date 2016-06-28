<?php

namespace Spatie\CookieConsent\Test;

class CookieConsentTest extends TestCase
{
    /** @test */
    public function it_provides_translations()
    {
        $this->assertTranslationExists('cookieConsent::texts.message');
        $this->assertTranslationExists('cookieConsent::texts.button_text');
    }

    /** @test */
    public function it_can_display_a_cookie_consent_view()
    {
        $html = view('layout')->render();

        $this->assertConsentDialogDisplayed($html);
    }

    public function it_will_not_show_the_cookie_consent_view_when_the_package_is_disabled()
    {
        $this->app['config']->set('laravel-cookie-consent.enabled', false);

        $this;
    }
}
