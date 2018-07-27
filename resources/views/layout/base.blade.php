<!DOCTYPE html>
<html lang="{{ $current_locale }}">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    {!! SEO::generate(true) !!}
    {{--<title>--}}
        {{--@if(View::hasSection('pageTitle'))--}}
            {{--@yield('pageTitle') - VIETNAM HOUSE--}}
        {{--@else--}}
            {{--VIETNAM HOUSE--}}
        {{--@endif--}}
    {{--</title>--}}
    {{--<meta name="description" content="">--}}
    {{--<meta name="keywords" content="">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Language" content="{{ $current_locale }}"/>
    <meta name="viewport"
          content="{{ Cookie::get('vnh_desktop', 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1') }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="google-site-verification" content="-a-KdRRZjx9pSqDJNV1Yk5ayQhu3U6_meiDAcewPpqo"/>
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>

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

<body class="{{ is_null(Route::current()) ? '' : ((strpos(Route::current()->getUri(), 'search-map') !== FALSE)?' change-body-padding ':'') }}">

<div id="top"></div>

@include('layout.header')

@yield('content')

@if(!is_null(Route::current()) && strpos(Route::current()->getUri(), 'search-map') === FALSE)
    @include('layout.footer')
@elseif (is_null(Route::current()))
    @include('layout.footer')
@endif

<a id="back_to_top" href="#">
    <span class="fa-stack">
        <img src="{{ asset('images/new-layout/totop.png') }}">
    </span>
</a>

<div class="modal sp-modal-contract" id="modal-like">
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
                <span class="close-btn">
                    <img src="{{ asset('images/new-layout/close.png') }}">
                </span>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
</style>

<script type="text/javascript">
    var estate_ajax = '{{ action('RealEstateController@index') }}';
    var txt_like_default_text = '{{ trans('front.like_default_text') }}';
    var txt_like_add = '{{ trans('front.like_add_text') }}';
    var txt_like_current = '{{ trans('front.like_current_text') }}';
    var txt_bt_like_selected = '{{ trans('entity.estate.liked') }}';
    var txt_bt_like_not_select = '{{ trans('entity.estate.like') }}';

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
