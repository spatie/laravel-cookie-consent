<?php

it('provides translations', function () {
    assertTranslationExists('cookie-consent::texts.message');
    assertTranslationExists('cookie-consent::texts.agree');
});

it('can display a cookie consent view', function () {
    $html = view('layout')->render();

    assertConsentDialogDisplayed($html);
});

it('will not show the cookie consent view when the package is disabled', function () {
    config()->set('cookie-consent.enabled', false);

    $html = view('layout')->render();

    assertConsentDialogIsNotDisplayed($html);
});

it('will not show the cookie consent view when the user has already consented', function () {
    request()->cookies->set(config('cookie-consent.cookie_name'), config('cookie-consent.cookie_name'), 1);

    $html = view('layout')->render();

    assertConsentDialogIsNotDisplayed($html);
});

it('contains the necessary CSS classes for Javascript functionality', function () {
    $html = view('dialog')->render();

    expect($html)->toContain('js-cookie-consent', 'js-cookie-consent-agree');
});
