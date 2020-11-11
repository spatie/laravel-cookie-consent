<?php

namespace Spatie\CookieConsent;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class CookieConsentMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (! config('cookie-consent.enabled')) {
            return $response;
        }

        if ($this->isRequestUriExempt($request)) {
            return $response;
        }

        if (! $response instanceof Response) {
            return $response;
        }

        if (! $this->containsBodyTag($response)) {
            return $response;
        }

        return $this->addCookieConsentScriptToResponse($response);
    }

    protected function containsBodyTag(Response $response): bool
    {
        return $this->getLastClosingBodyTagPosition($response->getContent()) !== false;
    }

    /**
     * @param \Illuminate\Http\Response $response
     *
     * @return $this
     */
    protected function addCookieConsentScriptToResponse(Response $response)
    {
        $content = $response->getContent();

        $closingBodyTagPosition = $this->getLastClosingBodyTagPosition($content);

        $content = ''
            .substr($content, 0, $closingBodyTagPosition)
            .view('cookieConsent::index')->render()
            .substr($content, $closingBodyTagPosition);

        return $response->setContent($content);
    }

    protected function getLastClosingBodyTagPosition(string $content = '')
    {
        return strripos($content, '</body>');
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function isRequestUriExempt($request)
    {
        $exemptUris = collect(config('cookie-consent.except') ?: []);

        $exemptUris->each(function($uri) use($exemptUris) {
            if(str_contains($uri, '/*')) {
                $exemptUris->push(str_replace('/*', '', $uri));
            }
        });

        $exemptUris = $exemptUris->map(fn($uri) => trim($uri, "\/ \t\n\r\0\x0B"));

        return $request->is($exemptUris->toArray());
    }
}
