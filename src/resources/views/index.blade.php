
@if($cookieConsentConfig['enabled'] && !$alreadyConsentedWithCookies)

    <div class="js-cookie-consent cookie-consent">
        @include('cookieConsent::dialogContents')
    </div>

    <script>

        var laravelCookieConsent = {

            consentedWithCookies: function () {
                this.setCookie({{ $cookieConsentConfig['cookie_name'] }}, 1, 365 * 20);
                this.hideCookieDialog();
            },

            hideCookieDialog: function () {
                document.getElementsByClassName('js-cookie-consent').style.display = "none";
            },

            setCookie: function (name, value, expirationInDays) {
                var date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + date.toUTCString();
                document.cookie = name + "=" + value + "; " + expires;
            },
        }

        document.getElementsByClassName('js-cookie-consent-agree').addEventListener("click", laravelCookieConsent.consentedWithCookies());
    </script>

@endif
