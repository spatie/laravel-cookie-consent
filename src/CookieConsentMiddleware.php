<?php

namespace Spatie\CookieConsent;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;

class CookieConsentMiddleware
{
    /** @var \Illuminate\Contracts\Foundation\Application */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (! $response instanceof Response) {
            return $response;
        }

        if (! $this->containsBodyTag($response)) {
            return $response;
        }

        return $this->addCookieConsentScriptToResponse($response);
    }

    /**
     * @param \Illuminate\Http\Response $response
     *
     * @return bool
     */
    protected function containsBodyTag(Response $response)
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

    /**
     * @param string $content
     *
     * @return int|bool
     */
    protected function getLastClosingBodyTagPosition($content = '')
    {
        return strripos($content, '</body>');
    }
}
