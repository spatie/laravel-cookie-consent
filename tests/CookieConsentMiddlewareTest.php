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

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $content = $result->getContent();

        $this->assertStringContainsString('<html><head></head><body>', $content);
        $this->assertStringContainsString('window.laravelCookieConsent', $content);
        $this->assertStringContainsString('</body></html>', $content);
    }

    /** @test */
    public function it_does_not_alter_content_that_does_not_contain_a_body_tag()
    {
        $request = new Request();

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->setContent('<html></html>');
        });

        $content = $result->getContent();

        $this->assertEquals('<html></html>', $content);
    }

    /** @test */
    public function it_does_not_use_a_secure_cookie_if_session_secure_is_false()
    {
        config(['session.secure' => false]);

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $this->assertStringContainsString(';path=/\'', $result->getContent());
        $this->assertStringNotContainsString(';path=/;secure\'', $result->getContent());
    }

    /** @test */
    public function it_uses_a_secure_cookie_if_config_session_is_set_to_secure()
    {
        config(['session.secure' => true]);

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $this->assertStringNotContainsString(';path=/\'', $result->getContent());
        $this->assertStringContainsString(';path=/;secure\'', $result->getContent());
    }

    /** @test */
    public function the_cookie_domain_is_set_by_the_session_domain_config_variable()
    {
        config(['session.domain' => 'some domain']);

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $this->assertStringContainsString('const COOKIE_DOMAIN = \'some domain\'', $result->getContent());
    }

    /** @test */
    public function the_cookie_samesite_attribute_is_not_set_if_config_session_is_set_to_false()
    {
        config(['session.same_site' => null]);

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $this->assertStringNotContainsString(';samesite=', $result->getContent());
    }

    /** @test */
    public function the_cookie_samesite_attribute_is_by_the_session_samesite_config_variable()
    {
        config(['session.same_site' => 'strict']);

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $this->assertStringContainsString(';samesite=strict', $result->getContent());
    }

    /** @test */
    public function it_uses_the_request_host_unless_session_domain_is_set()
    {
        config(['session.domain' => null]);

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $this->assertStringContainsString('const COOKIE_DOMAIN = \'localhost\'', $result->getContent());
    }
}
