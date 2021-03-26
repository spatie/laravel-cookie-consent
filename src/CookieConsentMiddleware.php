<?php

namespace Spatie\CookieConsent;

use Closure;
use Illuminate\Http\Response;

class CookieConsentMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (! config('cookie-consent.enabled')) {
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

    protected function addCookieConsentScriptToResponse(Response $response): Response
    {
        $content = $response->getContent();

        $closingBodyTagPosition = $this->getLastClosingBodyTagPosition($content);

        $content = ''
            .substr($content, 0, $closingBodyTagPosition)
            .view('cookie-consent::index')->render()
            .substr($content, $closingBodyTagPosition);

        return $response->setContent($content);
    }

    protected function getLastClosingBodyTagPosition(string $content = ''): bool | int
    {
        return strripos($content, '</body>');
    }
}
