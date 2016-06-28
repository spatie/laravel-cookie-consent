@if($cookieConsentConfig['enabled'] && !$alreadyConsentedWithCookies)

    @include('cookieConsent::dialogContents')

    <script>

        var laravelCookieConsent = {

            consentedWithCookies: function () {
                laravelCookieConsent.setCookie( '{{ $cookieConsentConfig['cookie_name'] }}' , 1, 365 * 20);
                laravelCookieConsent.hideCookieDialog();
            },

            hideCookieDialog: function () {
                var dialogs = document.getElementsByClassName('js-cookie-consent');

                for (var i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = "none";
                }
            },

            init: function() {
                var buttons = document.getElementsByClassName('js-cookie-consent-agree');

                for (var i = 0; i < buttons.length; ++i) {
                    buttons[i].addEventListener("click", laravelCookieConsent.consentedWithCookies);
                }
            },

            setCookie: function (name, value, expirationInDays) {
                var date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + date.toUTCString();
                document.cookie = name + "=" + value + "; " + expires;
            },
        }

        laravelCookieConsent.init();
    </script>

@endif
