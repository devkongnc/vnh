<!-- footer -->
<div class="footer">
    <div class="content-m">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="copyright">
                    <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}" class="logo-f">
                        <img src="{{ asset('images/new-layout/logo-f.svg') }}" >
                    </a>
                    <span>© Vietnamhouse.Inc ALL RIGHTS RESERVED </span>
                </div>

            </div>
            <div class="col-md-6 col-sm-6">
                <ul class="footer-menu">
                    <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/sitemap') }}">@lang('front.support_footer.sitemap')</a></li>
                    <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/privacy') }}">@lang('front.support_footer.policy')</a></li>
                </ul>
            </div>

        </div>
    </div>
</div>
