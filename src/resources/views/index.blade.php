@if($cookieConsentConfig['enabled'] && !$alreadyConsentedWithCookies)

    <div class="js-cookie-consent-message cookie-consent">
        @include('laravelCookieConsent::dialogContents')
    </div>

    <script>

        var laravelCookieConsent = {

            agreeWithCookies: function () {
                this.setCookie({{ $cookieConsentConfig['cookie_name'] }}, 1, 365 * 20);
                this.hideCookieDialog();
            },

            hideCookieDialog: function () {
                document.getElementsByClassName('js-cookie-message').style.display = "none";
            },

            setCookie: function (name, value, expirationInDays) {
                var date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + date.toUTCString();
                document.cookie = name + "=" + value + "; " + expires;
            },
        }

        document.getElementsByClassName('js-cookie-consent-agree').addEventListener("click", laravelCookieConsent.agreeWithCookies());
    </script>

@endif
