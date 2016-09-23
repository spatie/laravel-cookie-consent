<?php

namespace Spatie\CookieConsent;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;

class CookieConsentMiddleware
{
    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $content = $response->getContent();

            $cookieConsentHTML = view('cookieConsent::index')->render();

            if (($bodyPosition = strripos($content, '</body>')) !== false) {
                $content = ''
                    .substr($content, 0, $bodyPosition)
                    .$cookieConsentHTML
                    .substr($content, $bodyPosition);
            }

            $response->setContent($content);
        }

        return $response;
    }
}
