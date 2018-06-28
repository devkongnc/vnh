<!DOCTYPE html>
<html lang="{{ $current_locale }}">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <title>VIETNAM HOUSE</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Language" content="{{ $current_locale }}"/>
    <meta name="viewport"
          content="{{ Cookie::get('vnh_desktop', 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1') }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="google-site-verification" content="-a-KdRRZjx9pSqDJNV1Yk5ayQhu3U6_meiDAcewPpqo"/>
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>
{!! SEO::generate(true) !!}
<!-- Favicon
    ============================================== -->
    <link rel="shortcut icon" href="{{ asset('images/new-layout/favicon.png') }}">
    <!-- Mobile Specific
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSS Files
    ================================================== -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/new-layout/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-layout/animate.css') }}">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/new-layout/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-layout/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/new-layout/gallery.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/new-layout/jquery.range.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/new-layout/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/new-layout/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/new-layout/bootstrap-slider.min.css') }}">

    <script src="{{ asset('js/new-layout/jquery.min.js') }}"></script>
    <script src="{{ asset('js/new-layout/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/new-layout/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/new-layout/jquery.wow.min.js') }}"></script>
    <script src="{{ asset('js/new-layout/wow.min.js') }}"></script>
    <script src="{{ asset('js/new-layout/owl.carousel.js') }}"></script>
    <script src="{{ asset('js/new-layout/gallery.js') }}"></script>

    <style type="text/css">
        <?php if (App::isLocale('ja')) { ?>
		body {
            font-family: "Noto Sans Japanese", Arial, "sans-serif";
        }
        <?php } ?>
        div.phpdebugbar pre {
            width: 1000px;
        }
    </style>

    @yield('styles')
</head>

<body>

<div id="top"></div>
<div class="menu-fix" id="menu-fix">
    <div id="nav" class="content-l">
        <a href="{{ URL::to('/') }}" class="logo2"><img src="{{ asset('images/new-layout/logo.svg') }}"></a>
        <a onclick="$('.aside').asidebar('open')" class="menu-btn"><img src="{{ asset('images/new-layout/menu.png') }}"></a>
        <div class="like-page like-number">
            <a href="#" data-toggle="modal" data-target="#modal-like">
                <span class="numlike like-count">
                	<span class="invisible">0</span>
                </span>
            </a>
        </div>
        <a href="tel:0122-911-2100" class="hotline"><img src="{{ asset('images/new-layout/icon-phone.png') }}"> <span>0122 911 2100</span></a>
        {{-- search all page --}}
        <div class="search-hidden">
            <a class="open-search-hidden">@lang('front.top_search_toggle')</a>
            <section class="wrap-search-box">
                @include('partials.search_box')
            </section>
        </div>
    </div>
</div>

@include('layout.header')

@yield('content')

@include('layout.footer')

<script type="text/javascript" src="{{ asset('js/new-layout/asidebar.jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/new-layout/jquery.range.js') }}"></script>
<script src="{{ asset('js/new-layout/modernizr.custom.js') }}"></script>
<script type="text/javascript" src="{{ elixir('js/main.js') }}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy_KoPR6v-mzse7nWjricn1TTmnw9OP44"></script>
<script src="{{ asset('js/new-layout/scripts.js') }}"></script>

@yield('scripts')

<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5GGNW3');
</script>
</body>

</html>
