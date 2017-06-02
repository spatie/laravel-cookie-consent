<div class="js-cookie-consent cookie-consent">

    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}
    </span>

    <button class="js-cookie-consent-agree cookie-consent__agree">
        {{ trans('cookieConsent::texts.agree') }}
    </button>

    @if($cookieConsentConfig['cookie_policy_url'])

    <a href="{{ $cookieConsentConfig['cookie_policy_url'] }}" class="js-cookie-consent-agree cookie-consent__policy">
        {{ trans('cookieConsent::texts.policy') }}
    </a>

    @endif

</div>
