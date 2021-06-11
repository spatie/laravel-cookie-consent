@if($cookieConsentConfig['enabled'] && ! $alreadyConsentedWithCookies)

    @include('cookie-consent::dialogContents')

    <script>

        window.laravelCookieConsent = (function () {

            const ACCEPT_COOKIE_VALUE = 1;
            const REFUSE_COOKIE_VALUE = 0;
            const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

            function consentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', ACCEPT_COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function refuseCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', REFUSE_COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (
                    document.cookie.split('; ').indexOf(name + '=' + ACCEPT_COOKIE_VALUE) !== -1
                    || document.cookie.split('; ').indexOf(name + '=' + REFUSE_COOKIE_VALUE) !== -1
                );
            }

            function hideCookieDialog() {
                const dialogs = document.getElementsByClassName('js-cookie-consent');

                for (let i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = 'none';
                }
            }

            function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value
                    + ';expires=' + date.toUTCString()
                    + ';domain=' + COOKIE_DOMAIN
                    + ';path=/{{ config('session.secure') ? ';secure' : null }}'
                    + '{{ config('session.same_site') ? ';samesite='.config('session.same_site') : null }}';
            }

            if (cookieExists('{{ $cookieConsentConfig['cookie_name'] }}')) {
                hideCookieDialog();
            }

            const acceptButtons = document.getElementsByClassName('js-cookie-consent-agree');

            for (let i = 0; i < acceptButtons.length; ++i) {
                acceptButtons[i].addEventListener('click', consentWithCookies);
            }

            const refuseButtons = document.getElementsByClassName('js-cookie-consent-refuse');

            for (let i = 0; i < refuseButtons.length; ++i) {
                refuseButtons[i].addEventListener('click', refuseCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                refuseCookies: refuseCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

@endif
