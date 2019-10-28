@if($cookieConsentConfig['enabled'] )

    @include('cookieConsent::dialogContents')

    <script>

        window.laravelCookieConsent = (function () {

            const COOKIE_VALUE = 1;
            const DISAGREE_COOKIE_VALUE = 0;
            const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

            function consentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }
            function hideConsentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', DISAGREE_COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1 ||
                    document.cookie.split('; ').indexOf(name + '=' + DISAGREE_COOKIE_VALUE) !== -1
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
                    + ';path=/{{ config('session.secure') ? ';secure' : null }}';
            }

            if (cookieExists('{{ $cookieConsentConfig['cookie_name'] }}')) {
                hideCookieDialog();
            }

            const buttons = document.getElementsByClassName('js-cookie-consent-agree');
            const disagree_button = document.getElementsByClassName('js-cookie-consent-disagree');

            for (let i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener('click', consentWithCookies);
            }
            for (let i = 0; i < disagree_button.length; ++i) {
                disagree_button[i].addEventListener('click', hideConsentWithCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                hideConsentWithCookies: hideConsentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

@endif
