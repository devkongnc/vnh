<div class="header">
    <div id="nav" class="content-l center">
        <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}" class="logo"><img src="{{ asset('images/new-layout/logo.svg') }}" ></a>
        <a  onclick="$('.aside').asidebar('open')" class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}" ></a>
        {{-- <div class="">5</div> --}}
        <div class="like-page like-number">
            <a href="#" data-toggle="modal" data-target="#modal-like">
                <span class="numlike like-count">
                    <span class="invisible">0</span>
                </span>
            </a>
        </div>
        <a href="tel:0122-911-2100" class="hotline"><img src="{{ asset('images/new-layout/icon-phone.png') }}"> <span>0122 911 2100</span></a>
    </div>
</div>


<div class="aside">
  <div class="aside-header">
    <span class="close-btn" data-dismiss="aside" aria-hidden="true"><img src="{{ asset('images/new-layout/close.png') }}" ></span>
  </div>
  <div class="aside-contents">
    <ul class="menu-aside">
        <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/') }}">@lang('menu.header.top')</a></li>
        <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/category') }}">Category</a></li>
        <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/support/area') }}">Support Area</a></li>
        <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/support/step') }}">Support Step</a></li>
        <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/profile') }}">Company Profile</a></li>
        <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/privacy') }}">Privacy Policy</a></li>
        <li><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/contact') }}">@lang('menu.contact')</a></li>
   </ul>
   <div class="aside-bot">
        <a href="#" class="search-aside"><img src="{{ asset('images/new-layout/icon-search-f.png') }}" > 住居を探す</a>
        <ul class="language">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class='{{ ((Lang::locale() === $localeCode) ? "active" : "") }}'>
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                        {{ $properties['native'] }}
                    </a>
                </li>
            @endforeach
        </ul>
   </div>

  </div>
</div>
<div class="aside-backdrop"></div>

<!-- search home page-->
<?php if (Route::is('home')){ ?>
<div class="intro-section">
    <div class="content-l">
        <div class="img-section">
                <img src="{{ asset('images/new-layout/top-img.jpg') }}" >
                <div class="label-intro owl-carousel owl-theme" >
                    <div class="item">
                        <img src="{{ asset('images/new-layout/lb-no1.png') }}" >
                    </div>
                        <div class="item">
                        <img src="{{ asset('images/new-layout/lb-no1.png') }}" >
                    </div>
                        <div class="item">
                        <img src="{{ asset('images/new-layout/lb-no1.png') }}" >
                    </div>
                </div>

                <h1 class="title-big">心地よいオフィス探しを</h1>
        </div>

        <div class="content-m">

            @include('partials.search_box')

            <div class="bottom-btn">
                <a href="#" class="blk-btn">レンタルオフィスをご希望の方</a>
                <a href="#" class="blk-btn quest-btn">30人規模オフィス面積の算出</a>
            </div>

        </div>
    </div>
</div>
<?php } ?>

{{-- breadcrumb --}}
<?php if (Route::current()->getName() != 'home'){ ?>
<div class="breadcrumb-blk">
    <div class="content-l">
        <div class="row">
            <div class="col-md-12">
        <ul>
            <li><a href="#">トップページ</a></li>
            <li><a href="#">オフィス特集</a></li>
            <li><a href="#">とにかくオシャレなオフィス</a></li>
        </ul>
        </div>
        </div>
    </div>
</div>
<?php } ?>