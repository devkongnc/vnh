<!-- Page headder -->

{{--Fixed Header--}}
<div class="menu-fix" id="menu-fix">
    <div id="nav" class="content-l">
        <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}"
           class="logo2"><img src="{{ asset('images/new-layout/logo.svg') }}"></a>
        <a onclick="$('.aside').asidebar('open')" class="menu-btn"><img
                    src="{{ asset('images/new-layout/menu.png') }}"></a>
        <div class="like-page like-number">
            <a href="#" data-toggle="modal" data-target="#modal-like">
                <span class="numlike like-count">
                	<span class="invisible">0</span>
                </span>
            </a>
        </div>
        <a href="tel:0122-911-2100" class="hotline"><img src="{{ asset('images/new-layout/icon-phone.png') }}">
            <span>0122 911 2100</span></a>
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
            <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}">@lang('menu.header.top')</a>
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
<style>
    #fill1 {
        border-radius: 0;
        width: 26px;
        height: 23px;
        border: 3px solid #f7931e;
        color: #f7931e;
        font-family: "Gen Shin Gothic";
        font-size: 12px;
        font-style: normal;
        font-stretch: normal;
        font-weight: 700;
        text-align: left;
    }
</style>

@if (Route::is('home'))
    {{--Header for Top page--}}
    <div class="header">
        <div class="direct_bar_wrap">
            <div id="direct_bar" class="content-l">
                <div class="direct_bar_lang pull-left">
                    <ul class="nav navbar-nav">
                        <li><a href="#" class="dropdown-toggle"
                               data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="icon_global"></span> {{ LaravelLocalization::getCurrentLocaleNative() }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li class='{{ ((Lang::locale() === $localeCode) ? "active" : "") }}'>
                                        <a rel="alternate" hreflang="{{ $localeCode }}"
                                           href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="direct_bar_list pull-right">
                    <ul class="nav navbar-nav">
                        <li><a href="#">HCMC 住居</a></li>
                        <li class="active"><a href="#">HCMC オフィス</a></li>
                        <li><a href="#">HaNoi 住居</a></li>
                        <li><a href="#">HaNoi オフィス</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="nav" class="content-l center">
            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}" class="logo"><img
                        src="{{ asset('images/new-layout/logo.svg') }}"></a>
            <a onclick="$('.aside').asidebar('open')"
               class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}"></a>
            <div class="mail-contact">
                <a href="#" data-toggle="modal" data-target="#modal-like">
                    <span class="numlike like-count"> <span class="invisible">0</span> </span>
                </a>
            </div>
            <div class="like-page like-number">
                <a href="#" data-toggle="modal" data-target="#modal-like">
                    <span class="numlike like-count"> <span class="invisible">0</span> </span>
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
                        if (file_exists($url_banner)) { break; } else { $url_banner = ''; }
                    }
                }
                if ($url_banner == '') { $url_banner = 'images/new-layout/top-img.jpg'; }
                ?>
                <img src="{{ asset($url_banner) }}"/>
                <div class="label-intro owl-carousel owl-theme">
                    <div class="item"> <img src="{{ asset('images/new-layout/lb-no1.png') }}"> </div>
                    <div class="item"> <img src="{{ asset('images/new-layout/lb-no1.png') }}"> </div>
                    <div class="item"> <img src="{{ asset('images/new-layout/lb-no1.png') }}"> </div>
                </div>
                <h1 class="title-big">@lang('front.banner_title')</h1>
            </div>
            <div class="content-m search-header">
                @include('partials.search_box',['position_search' => 'banner'])
                <div class="bottom-btn">
                    <a href="#" class="blk-btn">レンタルオフィスをご希望の方</a>
                    <a href="#" class="blk-btn quest-btn">30人規模オフィス面積の算出</a>
                </div>
            </div>
        </div>
    </div>
@else
    {{--Header for Another Page--}}
    <div class="header page-module">
        <div id="nav" class="content-l">
            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}"
               class="logo2"><img src="{{ asset('images/new-layout/logo.svg') }}"></a>
            <a onclick="$('.aside').asidebar('open')" class="menu-btn"><img
                        src="{{ asset('images/new-layout/menu.png') }}"></a>
            <div class="like-page like-number">
                <a href="#" data-toggle="modal" data-target="#modal-like">
                    <span class="numlike like-count">
                        <span class="invisible">0</span>
                    </span>
                </a>
            </div>
            <a href="tel:0122-911-2100" class="hotline"><img src="{{ asset('images/new-layout/icon-phone.png') }}">
                <span>0122 911 2100</span></a>
            <div class="search-hidden search-header">
                <a class="open-search-hidden">@lang('front.top_search_toggle')</a>
                <section class="wrap-search-box">
                    @include('partials.search_box',['position_search' => 'header'])
                </section>
            </div>
        </div>
    </div>
@endif

