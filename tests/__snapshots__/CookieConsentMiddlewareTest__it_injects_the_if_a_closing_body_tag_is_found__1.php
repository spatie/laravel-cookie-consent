<?php

return '<html><head></head><body><div class="js-cookie-consent cookie-consent">

    <span class="cookie-consent__message">
        Your experience on this site will be improved by allowing cookies.
    </span>

    <button class="js-cookie-consent-agree cookie-consent__agree">
        Allow cookies
    </button>

</div>

    <script>

        window.laravelCookieConsent = (function () {

            var COOKIE_VALUE = 1;

            function consentWithCookies() {
                setCookie(\'laravel_cookie_consent\', COOKIE_VALUE, 365 * 20);
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split(\'; \').indexOf(name + \'=\' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                var dialogs = document.getElementsByClassName(\'js-cookie-consent\');

                for (var i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = \'none\';
                }
            }

            function setCookie(name, value, expirationInDays) {
                var date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + \'=\' + value + \'; \' + \'expires=\' + date.toUTCString() +\';path=/\';
            }

            if(cookieExists(\'laravel_cookie_consent\')) {
                hideCookieDialog();
            }

            var buttons = document.getElementsByClassName(\'js-cookie-consent-agree\');

            for (var i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener(\'click\', consentWithCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

</body></html>';
