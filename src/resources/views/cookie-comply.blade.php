@unless($alreadyAgreedWithCookies)

    <div id="cookieMessage">
        @include('laravelCookieConsent::cookie-comply-dialog-content')
    </div>

    <script>

        var laravelCookieComply = {

            agreeWithCookies: function () {
                this.setCookie({{ $cookieConsentConfig['cookie_name'] }}, 1, 365 * 20);
                this.hideCookieDialog();
            },

            hideCookieDialog: function () {
                document.getElementById('cookieMessage').style.display = "none";
            },

            setCookie: function (name, value, expirationInDays) {
                var date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + date.toUTCString();
                document.cookie = name + "=" + value + "; " + expires;
            },
        }

        document.getElementById('agreeWithCookies').addEventListener("click", laravelCookieComply.agreeWithCookies());
    </script>

@endunless
