<header class="page-{{ !empty(Route::currentRouteName()) ? Route::currentRouteName() : Request::path() }} {{ if_route(['home']) ? 'home' : 'page' }}">
    <nav>
        <div class="logo">
            <a href="{{ route('home') }}"><img src="/images/logo.svg" alt="logo"></a>
        </div>
        <!-- <div class="nav-menu">
            <div class="top-text">@lang('menu.header.slogan')</div>
            <ul>
                <li><a href="/">@lang('menu.header.top')</a></li>
                <li><a href="#">内覧・入居フロー</a></li>
                <li><a href="#">@lang('menu.header.faq')</a></li>
                <li><a href="#">不動産オーナー様へ</a></li>
                <li><a href="/about/company">@lang('menu.header.about')</a></li>
                <li><a href="/contact">@lang('menu.header.contact')</a></li>
            </ul>
        </div> -->
        <div class="right-top text-uppercase">
            <a href="#" class="search-phone {{ (if_route(['home'])) ? 'hidden' : '' }}">
                <span class="icon-search"></span>
            </a>
            <a href="tel:@lang('entity.page.contact.contact by phone.number')" class="hotline-phone">
                <span class="icon-phone"></span>
            </a>
            <div class="hotline">
                <p><span class="icon-phone"></span><a href="tel:@lang('entity.page.contact.contact by phone.number')">@lang('entity.page.contact.contact by phone.number')</a></p>
            </div>
            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[11]->permalink) }}" class="contact-link">Contact</a>
            <div class="like-page">
                <a href="#" data-toggle="modal" data-target="#modal-like"><span class="numlike like-count"><span class="invisible">0</span></span>Like</a>
                <span class="desc-like invisible">@lang('front.like hover', ['num' => '<span class="like-count">0</span>'])</span>
            </div>
            <div class="menu-toggle">
                <input id="menu-trigger" class="hidden" type="checkbox" value="">
                <label for="menu-trigger" type="button" class="menu-trigger-label btn-collapse">
                    <span class="ico-bar line-1"></span>
                    <span class="ico-bar line-2"></span>
                    <span class="ico-bar line-3"></span>
                </label>
                <div class="mobile-menu-wrapper" id="mobile-menu-wrapper">
                    <ul class="list">
                        <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}">@lang('menu.header.top')</a></li>
                    </ul>
                    {{ showMenu(null, $menu, $pages_by_id, 1) }}
                    <ul class="list">
                        <li class="language hidden-xs">
                            <a href="#" class="label-toggle">@lang('front.language')</a>
                            <ul>
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a class="lang" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                            </ul>
                        </li>
                    </ul>
                    <form action="{{ action('HomeController@desktop') }}" method="GET" class="form-inline" role="form">
                        @if (Cookie::get('vnh_desktop') === NULL)
                            <button type="submit" name="action" value="desktop" class="desktop-view btn btn-primary visible-xs">@lang('front.view.desktop')</button>
                        @else
                            <button type="submit" name="action" value="normal" class="desktop-view btn btn-primary">@lang('front.view.normal')</button>
                        @endif
                    </form>
                </div>
                <div class="menu-backdrop"></div>
            </div>
        </div>
    </nav>
    @if (!if_route(['home', 'search-advanced']))
    <div class="top-bar-search hidden-xs hidden-sm">
        <a class=""><span class="icon-search"></span> @lang('search.title') <span class="btn-open icon-arrow-down"></span></a>
    </div>
    <div class="wrap-search-box open">
        @include('partials.search_box')
    </div>
    @endif
    @if (if_route(['home']))
        <div class="search_home_custom hidden-md hidden-lg">
            <a href="#" class="search-phone">
                @lang('search.advanced search') <span class="icon-arrow-down"></span>
            </a>
        </div>
    @endif
</header>
