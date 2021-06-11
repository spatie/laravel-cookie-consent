<?php

namespace Spatie\CookieConsent\Test;

class CookieConsentTest extends TestCase
{
    /** @test */
    public function it_provides_translations()
    {
        $this->assertTranslationExists('cookie-consent::texts.message');
        $this->assertTranslationExists('cookie-consent::texts.agree');
        $this->assertTranslationExists('cookie-consent::texts.refuse');
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
        $this->app['config']->set('cookie-consent.enabled', false);

        $html = view('layout')->render();

        $this->assertConsentDialogIsNotDisplayed($html);
    }

    /** @test */
    public function it_will_not_show_the_cookie_refuse_button()
    {
        $html = view('layout')->render();

        $this->assertRefuseButtonIsNotDisplayed($html);
    }

    /** @test */
    public function it_can_display_the_refuse_button_when_the_option_is_enabled()
    {
        $this->app['config']->set('cookie-consent.refuse_enabled', true);

        $html = view('layout')->render();

        $this->assertRefuseButtonDisplayed($html);
    }

    /** @test */
    public function it_will_not_show_the_cookie_consent_view_when_the_user_has_already_consented()
    {
        request()->cookies->set(config('cookie-consent.cookie_name'), cookie(config('cookie-consent.cookie_name'), 1));

        $html = view('layout')->render();

        $this->assertConsentDialogIsNotDisplayed($html);
    }

    /** @test */
    public function it_will_not_show_the_cookie_consent_view_when_the_user_has_already_refused()
    {
        request()->cookies->set(config('cookie-consent.cookie_name'), cookie(config('cookie-consent.cookie_name'), 0));

        $html = view('layout')->render();

        $this->assertConsentDialogIsNotDisplayed($html);
    }

    /** @test */
    public function it_contains_the_necessary_css_classes_for_javascript_functionality()
    {
        $html = view('dialog')->render();

        $this->assertStringContainsString('js-cookie-consent', $html);
        $this->assertStringContainsString('js-cookie-consent-agree', $html);
    }

    /** @test */
    public function it_contains_the_necessary_css_classes_for_refuse_javascript_functionality()
    {
        $this->app['config']->set('cookie-consent.refuse_enabled', true);

        $html = view('dialog')->render();

        $this->assertStringContainsString('js-cookie-consent', $html);
        $this->assertStringContainsString('js-cookie-consent-agree', $html);
        $this->assertStringContainsString('js-cookie-consent-refuse', $html);
    }
}
