<?php

namespace Spatie\CookieConsent\Test;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\CookieConsent\CookieConsentMiddleware;

class CookieConsentMiddlewareTest extends TestCase
{
    /** @test */
    public function it_injects_the_if_a_closing_body_tag_is_found()
    {
        $request = new Request();

        $middleware = new CookieConsentMiddleware($this->app);

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $content = $result->getContent();

        $this->assertContains('<html><head></head><body>', $content);
        $this->assertContains('window.laravelCookieConsent', $content);
        $this->assertContains('</body></html>', $content);
    }

    /** @test */
    public function it_does_not_alter_content_that_does_not_contain_a_body_tag()
    {
        $request = new Request();

        $middleware = new CookieConsentMiddleware($this->app);

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->setContent('<html></html>');
        });

        $content = $result->getContent();

        $this->assertEquals('<html></html>', $content);
    }
}
