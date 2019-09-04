<?php

namespace Spatie\CookieConsent\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Spatie\CookieConsent\CookieConsentServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CookieConsentServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('laravel-blade-javascript.namespace', 'js');
        $app['config']->set('view.paths', [__DIR__.'/stubs/views']);
    }

    public function assertTranslationExists(string $key)
    {
        $this->assertTrue(trans($key) != $key, "Failed to assert that a translation exists for key `{$key}`");
    }

    protected function assertConsentDialogDisplayed(string $html)
    {
        $this->assertTrue($this->isConsentDialogDisplayed($html), 'Failed to assert that the consent dialog is displayed.');
    }

    protected function assertConsentDialogIsNotDisplayed(string $html)
    {
        $this->assertFalse($this->isConsentDialogDisplayed($html), 'Failed to assert that the consent dialog is not being displayed.');
    }

    protected function isConsentDialogDisplayed(string $html): bool
    {
        return \Illuminate\Support\Str::contains($html, [
            trans('cookieConsent::texts.message'),
            trans('cookieConsent::texts.button_text'),
        ]);
    }
}
