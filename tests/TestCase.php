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
}
