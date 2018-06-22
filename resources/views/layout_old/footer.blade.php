<footer>
    <div class="menu-list-wrapper row">
        <ul class="menu-list col-sm-4 hidden-xs">
            <li><a href="{{ action('RealEstateController@index') }}">@lang('menu.arrival')</a></li>
            <li><a href="{{ action('CategoryController@index') }}">@lang('menu.categories')</a></li>
            <li><a href="{{ action('HomeController@searchForm') }}">@lang('menu.search advanced')</a></li>
        </ul>
        <ul class="menu-list col-sm-4 hidden-xs">
            <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[7]->permalink) }}">@lang('menu.footer.3')</a>
            </li>
            <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[2]->permalink) }}">@lang('menu.footer.4')</a></li>
            </li>
        </ul>
        <ul class="menu-list col-sm-4 hidden-xs">
            <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[3]->permalink) }}">@lang('menu.footer.6')</a></li>
            <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[1]->permalink) }}">@lang('menu.footer.7')</a></li>
            <li><a href="{{ action('ReviewController@index') }}">@lang('menu.review')</a></li>
        </ul>
        <div class="like-face col-sm-4 hidden-xs">
            <div class="hidden">
                <i class="fa fa-facebook" aria-hidden="true"></i>
                <span class="wrap-like-fb">3270</span>
            </div>
        </div>
        <div class="brand-logo col-sm-4">
            <div class="row">
                <div class="language col-xs-3 visible-xs">
                    <a href="#" class="toggle">@lang('front.language')</a>
                    <ul class="language-toggle">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li>
                            <a class="lang" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">{{ $properties['native'] }}</a>
                        </li>
                    @endforeach
                    </ul>
                </div>
                <a href="{{ route('home') }}" class="col-xs-6 col-md-12">
                    <img src="{{ asset('images/logo_black.svg') }}" alt="VietnamHouse"/>
                    <p>© Vietnamhouse.Inc ALL RIGHTS RESERVED</p>
                </a>
            </div>
        </div>
    </div>
    @if (if_route(['home']))
    <div id="copy-right" class="text-left hidden-xs">
        {!! option('partner') !!}
    </div>
    @endif
</footer>
<a href="#" id="back-to-top" title="Back to top"><img src="{{ asset('images/back-to-top.svg') }}" alt="back to top"></a>
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

