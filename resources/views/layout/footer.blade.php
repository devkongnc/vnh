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

<a id="back_to_top" href="#">
    <span class="fa-stack">
        <img src="{{ asset('images/new-layout/totop.png') }}" >
    </span>
</a>

<div class="modal" id="modal-like">
    <div class="modal-dialog modal-lg">
        <div class="popup-like modal-content">
            <div class="top-popup">
                <div>
                    <p>@lang('front.popup.contact.description')</p>
                    <p><span class="clear-like icon-close-light"><span class="path1"></span><span class="path2"></span></span> @lang('front.popup.contact.like remove')</p>
                </div>
                <div class="img-top">
                    <img class="img-responsive" src="{{ asset('images/like-orange.svg') }}" alt="like">
                </div>
            </div>
            <div class="list-house-popup"></div>
            @include('partials.contact_form', ['prefix' => 'like'])
            <div class="close-like" data-dismiss="modal" aria-label="Close">
                <span class="icon-close-light"><span class="path1"></span><span class="path2"></span></span>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .modal-content{padding: 25px}
</style>