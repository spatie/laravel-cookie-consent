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

    /**
     * @param $key
     *
     * @return bool
     */
    public function assertTranslationExists($key)
    {
        $this->assertTrue(trans($key) != $key, "Failed to assert that a translation exists for key `{$key}`");
    }

    /**
 * @param string $html
 */
    protected function assertConsentDialogDisplayed($html)
    {
        $this->assertTrue($this->isConsentDialogDisplayed($html), 'Failed to assert that the consent dialog is displayed.');
    }

    /**
     * @param string $html
     */
    protected function assertConsentDialogIsNotDisplayed($html)
    {
        $this->assertFalse($this->isConsentDialogDisplayed($html), 'Failed to assert that the consent dialog is not being displayed.');
    }

    /**
     * @param string $html
     *
     * @return bool
     */
    protected function isConsentDialogDisplayed($html)
    {
        return str_contains($html, [
            trans('cookieConsent::texts.message'),
            trans('cookieConsent::texts.button_text'),
        ]);
    }
}
