<?php

namespace Spatie\CookieConsent\Test;

class CookieConsentTest extends TestCase
{
    /** @test */
    public function it_tests()
    {
        $view = view('layout')->render();

        dd($view);
    }

}
