<?php

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;
use \Illuminate\Support\Str;

uses(Spatie\CookieConsent\Test\TestCase::class)->in('.');

// Functions

function assertTranslationExists(string $key)
{
    assertTrue(
        trans($key) != $key,
        "Failed to assert that a translation exists for key `{$key}`"
    );
}

function assertConsentDialogDisplayed(string $html)
{
    assertTrue(
        isConsentDialogDisplayed($html),
        'Failed to assert that the consent dialog is displayed.'
    );
}

function assertConsentDialogIsNotDisplayed(string $html)
{
    assertFalse(
        isConsentDialogDisplayed($html),
        'Failed to assert that the consent dialog is not being displayed.'
    );
}

function isConsentDialogDisplayed(string $html): bool
{
    return Str::contains($html, [
        trans('cookie-consent::texts.message'),
        trans('cookie-consent::texts.button_text'),
    ]);
}
