<?php

namespace Spatie\CookieConsent\Test;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\CookieConsent\RemoveCookiesWithoutConsentMiddleware;

class RemoveCookiesWithoutConsentMiddlewareTest extends TestCase
{
    /** @test */
    public function it_removes_cookies_when_consent_is_not_given()
    {
        $request = new Request();
        $rawResponse = (new Response())->withCookie('test-cookie', 42);

        $this->assertNotEmpty($rawResponse->headers->getCookies(), 'Raw response doesn\'t include any cookies!');

        $middleware = new RemoveCookiesWithoutConsentMiddleware($this->app);
        $response = $middleware->handle($request, function ($request) use ($rawResponse) {
            return $rawResponse;
        });

        $this->assertEmpty($response->headers->getCookies(), 'Cookies should be, but aren\'t, removed when consent isn\'t given!');
    }

    /** @test */
    public function it_does_not_remove_cookies_when_consent_is_given()
    {
        $request = new Request();
        $request->cookies->set(config('cookie-consent.cookie_name'), cookie(config('cookie-consent.cookie_name'), 1));

        $rawResponse = (new Response())->withCookie('test-cookie', 42);
        $this->assertNotEmpty($rawResponse->headers->getCookies(), 'Raw response doesn\'t include any cookies!');

        $middleware = new RemoveCookiesWithoutConsentMiddleware($this->app);
        $response = $middleware->handle($request, function ($request) use ($rawResponse) {
            return $rawResponse;
        });

        $this->assertNotEmpty($response->headers->getCookies(), 'Cookies shouldn\'t be, but are, removed despite the fact consent is given!');
    }
}
