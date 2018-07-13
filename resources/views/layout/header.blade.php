<!-- Page headder -->

{{--Fixed Header--}}
<div class="menu-fix" id="menu-fix">
    <div id="nav" class="content-l">
        <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}"
           class="logo2"><img src="{{ asset('images/new-layout/logo.svg') }}"></a>
        <div id="menu_head_group">
            <a onclick="$('.aside').asidebar('open')"
               class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}"></a>
            <a href="#">
                <div class="mail-contact"></div>
            </a>
            <a href="#" data-toggle="modal" data-target="#modal-like">
                <div class="like-page like-number">
                    <span class="numlike like-count"> <span class="invisible">0</span> </span>
                </div>
            </a>
        </div>
        {{-- search all page --}}
        <div class="search-hidden">
            <a class="open-search-hidden">@lang('front.top_search_toggle')</a>
            <section class="wrap-search-box">
                @include('partials.search_box',['position_search' => 'header'])
            </section>
        </div>
    </div>
</div>

{{-- Menu side bar --}}
<div class="aside">
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
            <div id="menu_shortcut_group">
                {{ showMenu(null, $menu_top, $pages_by_id, 1) }}
            </div>
            <div id="menu_head_group">
                <a onclick="$('.aside').asidebar('open')"
                   class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}"></a>
                <a href="#">
                    <div class="mail-contact"></div>
                </a>
                <a href="#" data-toggle="modal" data-target="#modal-like">
                    <div class="like-page like-number">
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
                    <div class="item"><img src="{{ asset('images/new-layout/lb-no1.png') }}"></div>
                    <div class="item"><img src="{{ asset('images/new-layout/lb-no1.png') }}"></div>
                    <div class="item"><img src="{{ asset('images/new-layout/lb-no1.png') }}"></div>
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
            <div id="menu_head_group">
                <a onclick="$('.aside').asidebar('open')"
                   class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}"></a>
                <a href="#">
                    <div class="mail-contact"></div>
                </a>
                <a href="#" data-toggle="modal" data-target="#modal-like">
                    <div class="like-page like-number">
                        <span class="numlike like-count"> <span class="invisible">0</span> </span>
                    </div>
                </a>
            </div>
            <div class="search-hidden search-header">
                <a class="open-search-hidden">@lang('front.top_search_toggle')</a>
                <section class="wrap-search-box">
                    @include('partials.search_box',['position_search' => 'header'])
                </section>
            </div>
        </div>
    </div>
@endif

