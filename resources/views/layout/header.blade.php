<!-- Page headder -->

{{--Fixed Header--}}
<div class="menu-fix" id="menu-fix">
    <div id="nav" class="content-l">
        <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}"
           class="logo2 hide-mobile"><img src="{{ asset('images/new-layout/logo.svg') }}"></a>
        <div id="menu_head_group" class="show-mobile">
            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}">
                <img src="{{ asset('images/new-layout/sp-icn-home.png') }}">
            </a>
            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/contact') }}">
                <img src="{{ asset('images/new-layout/sp-icn-mail.png') }}">
            </a>
            <a href="tel:0793730086">
                <img src="{{ asset('images/new-layout/sp-icn-phone.png') }}">
            </a>
            <a href="#" class="sp-open-search-hidden sp-custom bt-modal-contract">
                <img src="{{ asset('images/new-layout/sp-icn-search.png') }}">
            </a>
            <a href="#" data-toggle="modal" data-target="#modal-like" class="bt-modal-contract">
                <div class="like-page like-number" data-toggle="tooltip">
                    <span class="numlike like-count"> <span class="invisible">0</span> </span>
                </div>
            </a>
            <a href="#" onclick="sp_toggle_aside_menu();" class="menu-btn bt-modal-contract">
                <img src="{{ asset('images/new-layout/sp-icn-menu.png') }}">
            </a>
        </div>
        <div id="menu_head_group" class="hide-mobile">
            <a onclick="$('.aside').asidebar('open')"
               class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}"></a>
            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/contact') }}">
                <div class="mail-contact"></div>
            </a>
            <a href="#" data-toggle="modal" data-target="#modal-like">
                <div class="like-page like-number" data-toggle="tooltip">
                    <span class="numlike like-count"> <span class="invisible">0</span> </span>
                </div>
            </a>
        </div>
        {{-- search all page --}}
        <div class="search-hidden sp-modal-contract">
            <a class="open-search-hidden hide-mobile">@lang('front.top_search_toggle')</a>
            <section class="wrap-search-box">
                <span class="close-btn search-fixed show-mobile">
                    <img src="{{ asset('images/new-layout/close.png') }}">
                </span>
                @include('partials.search_box',['position_search' => 'header'])
            </section>
        </div>
    </div>
</div>

{{-- Menu side bar --}}
<div class="aside sp-modal-contract">
    <div class="aside-header">
        <span class="close-btn" data-dismiss="aside" aria-hidden="true"><img
                    src="{{ asset('images/new-layout/close.png') }}"></span>
    </div>
    <div class="aside-contents">
        <ul class="menu-aside">
            <li>
                <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}">@lang('menu.header.top')</a>
            </li>
            {{ showMenu(null, $menu, $pages_by_id, 1) }}
        </ul>
        <div class="aside-bot">
            <ul class="language">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li class='{{ ((Lang::locale() === $localeCode) ? "active" : "") }}'>
                        <a rel="alternate" hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                            {{ $properties['native'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
<div class="aside-backdrop"></div>
@if (Route::is('home'))
    {{--Header for Top page--}}
    <div class="header">
        @include('partials.direct-bar')
        <div id="nav" class="content-l center">
            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}" class="logo"><img
                        src="{{ asset('images/new-layout/logo.svg') }}"></a>
            <div id="menu_shortcut_group" class="hide-mobile">
                {{ showMenu(null, $menu_top, $pages_by_id, 1) }}
            </div>
            <div id="menu_head_group" class="hide-mobile">
                <a onclick="$('.aside').asidebar('open')"
                   class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}"></a>
                <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/contact') }}">
                    <div class="mail-contact"></div>
                </a>
                <a href="#" data-toggle="modal" data-target="#modal-like">
                    <div class="like-page like-number" data-toggle="tooltip" data-container="body">
                        <span class="numlike like-count"> <span class="invisible">0</span> </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Banner And Search - Top page --}}
    <div class="intro-section">
        <div class="content-l">
            <div class="img-section">
                <?php
                $url_banner = '';
                if (!empty($slides) && !empty($resources) && count($resources) > 0) {
                    foreach ($resources as $resource) {
                        $url_banner = 'upload/' . $resource->folder . $resource->filename;
                        if (file_exists($url_banner)) {
                            break;
                        } else {
                            $url_banner = '';
                        }
                    }
                }
                if ($url_banner == '') {
                    $url_banner = 'images/new-layout/top-img.jpg';
                }
                ?>
                <img src="{{ asset($url_banner) }}"/>
                <div class="label-intro owl-carousel owl-theme">
                    @if (App::isLocale('ja'))
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no1-ja.png') }}"></div>
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no2-ja.png') }}"></div>
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no3-ja.png') }}"></div>
                    @elseif(App::isLocale('vi'))
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no1-vi.png') }}"></div>
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no2-vi.png') }}"></div>
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no3-vi.png') }}"></div>
                    @else
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no1-en.png') }}"></div>
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no2-en.png') }}"></div>
                        <div class="item"><img src="{{ asset('images/side-icon/lb-no3-en.png') }}"></div>
                    @endif
                </div>
                <h1 class="title-big">@lang('front.banner_title')</h1>
            </div>
            <div class="content-m search-header">
                @include('partials.search_box',['position_search' => 'banner'])
            </div>
        </div>
    </div>
@else
    {{--Header for Another Page--}}
    <div class="header page-module">
        @include('partials.direct-bar')
        <div id="nav" class="content-l">
            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}"
               class="logo2"><img src="{{ asset('images/new-layout/logo.svg') }}"></a>
            <div id="menu_head_group" class="hide-mobile">
                <a onclick="$('.aside').asidebar('open')"
                   class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}"></a>
                <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/contact') }}">
                    <div class="mail-contact"></div>
                </a>
                <a href="#" data-toggle="modal" data-target="#modal-like">
                    <div class="like-page like-number" data-toggle="tooltip" data-container="body">
                        <span class="numlike like-count"> <span class="invisible">0</span> </span>
                    </div>
                </a>
            </div>
            <div class="search-hidden search-header hide-mobile">
                <a class="open-search-hidden">@lang('front.top_search_toggle')</a>
                <section class="wrap-search-box">
                    @include('partials.search_box',['position_search' => 'header'])
                </section>
            </div>
        </div>
    </div>
@endif

