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

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-plugin.js') }}"></script>

    <style type="text/css">
        @import url('https://fonts.googleapis.com/earlyaccess/notosansjapanese.css');
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/css-lib.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ elixir('css/css-custom.min.css') }}">

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

<body class="{{ (Route::current()->getUri() == 'search-map')?' change-body-padding ':''}}">

<div id="top"></div>

@include('layout.header')

@yield('content')

@if(Route::current()->getUri() !== 'search-map')
    @include('layout.footer')
@endif

<a id="back_to_top" href="#">
    <span class="fa-stack">
        <img src="{{ asset('images/new-layout/totop.png') }}">
    </span>
</a>

<div class="modal" id="modal-like">
    <div class="modal-dialog modal-lg">
        <div class="popup-like modal-content">
            <div class="top-popup">
                <div>
                    <p>@lang('front.popup.contact.description')</p>
                    <p class="clear-like-wraper"><span class="clear-like icon-close-light"><span class="path1"></span><span class="path2"></span></span> @lang('front.popup.contact.like remove')
                    </p>
                </div>
                <div class="img-top">
                    <img class="img-responsive" src="{{ asset('images/new-layout/icon-heart-fill.png') }}" alt="like">
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
    .modal-content {
        padding: 25px
    }

    /*like popup start*/

    .popup-like>.close-like{position: absolute; font-size: 35px; top: 10px; right: 10px;}

    .clear-like-wraper{padding-left: 20px;}
    .clear-like{margin-right: 5px}
    .popup-like .list-house-popup .post-house {
        float: left;
        padding: 0 5px;
        position: relative;
    }
    .popup-like .list-house-popup .post-house .close-house {
        cursor: pointer;
        color: #000;
        position: absolute;
        top: 11px;
        right: 11px;
        font-size: 20px;
        line-height: 20px;
        border-radius: 100%;
        -webkit-transition: all .3s;
        transition: all .3s;
    }
    .icon-close-light .path1{position: relative}
    .icon-close-light .path1:before {
        content: "\f111";
        color: #000;
        font-family: FontAwesome;
        position: absolute;
        top: 0;
        right: 0;
        font-size: 22px;
    }
    .icon-close-light .path1:after {
        content: "\f00d";
        color: #fff;
        font-family: FontAwesome;
        position: absolute;
        top: 0px;
        right: 4px;
        font-size: 14px;
    }
    .popup-like .list-house-popup .post-house .feature-image>.item-brief {
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: rgba(0,0,0,.5);
        padding: 5px 10px;
        color: #fff;
        font-size: 12px;
    }
    .popup-like .list-house-popup .post-house .feature-image {
        position: relative;
    }
    .popup-like .list-house-popup .post-house .title {
        font-size: 12px;
        line-height: 14px;
        height: 28px;
        overflow: hidden;
        font-family: Verdana,sans-serif;
        margin: 3px 0 10px;
        -webkit-transition: color .2s linear;
        transition: color .2s linear;
    }
    /*like popup end*/

</style>

<script type="text/javascript">
    var estate_ajax = '{{ action('RealEstateController@index') }}';

    function estate_permalink(product_id) {
        return '{{ action('RealEstateController@show', 'product_id') }}'.replace('product_id', product_id);
    }
</script>
<script type="text/javascript" src="{{ elixir('js/js-custom.js') }}"></script>


@if(env('APP_ENV') == 'local' || env('APP_ENV') == 'develop')
    {{--key for local dev //vnh.local--}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy_KoPR6v-mzse7nWjricn1TTmnw9OP44"></script>
@else
    {{--key for server real //office.vietnamhouse.jp--}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('APP_MAP_KEY') }}"></script>
@endif


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
