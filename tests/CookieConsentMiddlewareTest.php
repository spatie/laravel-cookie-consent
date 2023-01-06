<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\CookieConsent\CookieConsentMiddleware;

it('injects the if a closing body tag is found', function () {
    $request = new Request();

    $middleware = new CookieConsentMiddleware();

    $result = $middleware->handle($request, function ($request) {
        return (new Response())->setContent('<html><head></head><body></body></html>');
    });

    $content = $result->getContent();

    expect($content)->toContain(
        '<html><head></head><body>',
        'window.laravelCookieConsent',
        '</body></html>'
    );
});

it('does not alter content that does not contain a body tag', function () {
    $request = new Request();

    $middleware = new CookieConsentMiddleware();

    $result = $middleware->handle($request, function ($request) {
        return (new Response())->setContent('<html></html>');
    });

    expect($result->getContent())->toContain('<html></html>');
});

it('does not use a secure cookie if session secure is false', function () {
    config()->set('session.secure', false);

    $middleware = new CookieConsentMiddleware();

    $result = $middleware->handle(new Request(), function () {
        return (new Response())->setContent('<html><head></head><body></body></html>');
    });

    expect($result->getContent())
        ->toContain(';path=/\'')
        ->not->toContain(';path=/;secure\'');
});

it('uses a secure cookie if config session is set to secure', function () {
    config(['session.secure' => true]);

    $middleware = new CookieConsentMiddleware();

    $result = $middleware->handle(new Request(), function () {
        return (new Response())->setContent('<html><head></head><body></body></html>');
    });

    expect($result->getContent())
        ->not->toContain(';path=/\'')
        ->toContain(';path=/;secure\'');
});

test('the cookie domain is set by the session domain config variable', function () {
    config(['session.domain' => 'some domain']);

    $middleware = new CookieConsentMiddleware();

    $result = $middleware->handle(new Request(), function () {
        return (new Response())->setContent('<html><head></head><body></body></html>');
    });

    expect($result->getContent())->toContain('const COOKIE_DOMAIN = \'some domain\'');
});

test('the cookie "samesite" attribute is not set if config session is set to false', function () {
    config(['session.same_site' => null]);

    $middleware = new CookieConsentMiddleware();

    $result = $middleware->handle(new Request(), function () {
        return (new Response())->setContent('<html><head></head><body></body></html>');
    });

    expect($result->getContent())->not->toContain(';samesite=');
});

test('the cookie "samesite" attribute is by the session "samesite" config variable', function () {
    config(['session.same_site' => 'strict']);

    $middleware = new CookieConsentMiddleware();

    $result = $middleware->handle(new Request(), function () {
        return (new Response())->setContent('<html><head></head><body></body></html>');
    });

    expect($result->getContent())->toContain(';samesite=strict');
});

it('uses the request host unless session domain is set', function () {
    config(['session.domain' => null]);

    $middleware = new CookieConsentMiddleware();

    $result = $middleware->handle(new Request(), function () {
        return (new Response())->setContent('<html><head></head><body></body></html>');
    });

    expect($result->getContent())->toContain('const COOKIE_DOMAIN = \'localhost\'');
});
