<!DOCTYPE html>
<html lang="{{ $current_locale }}">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	    <meta http-equiv="Content-Language" content="{{ $current_locale }}"/>
	    <meta name="viewport" content="{{ Cookie::get('vnh_desktop', 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1') }}">
	    <meta name="format-detection" content="telephone=no">
		<meta name="google-site-verification" content="-a-KdRRZjx9pSqDJNV1Yk5ayQhu3U6_meiDAcewPpqo" />
		<link href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>
		<meta name="keywords" content="@lang('entity.meta.keywords')">
	    {!! SEO::generate(true) !!}
	    {{-- <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:400,500"> --}}
		{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts_'. $current_locale . '.css') }}"> --}}
	    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	    @yield('styles')
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-5GGNW3');</script>
		<!-- End Google Tag Manager -->
	</head>
	<body class="{{ $current_locale }}">
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5GGNW3"
						  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		@include('layout.header') @yield('content')	@include('layout.footer')
		@if (Auth::check())
			<div id="adminbar">
			    <ul class="list-inline">
			        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
			        <form action="{{ action('HomeController@clearCache') }}" method="POST" class="form-inline" role="form">
			        	{{ csrf_field() }}
			        	<button type="submit" class="btn">Clear cache</button>
			        </form>
			        @yield('edit')
			    </ul>
			    <div class="clearfix"></div>
			</div>
			<div id="adminbar-placeholder"></div>
			<style type="text/css">
				div.phpdebugbar {
					bottom: 32px !important;
				}
			</style>
		@endif
		<script type="text/javascript">
			estate_ajax = '{{ action('RealEstateController@index') }}';
			search_ajax = '{{ action('HomeController@search') }}';
			function estate_permalink(product_id) {
				return '{{ action('RealEstateController@show', 'product_id') }}'.replace('product_id', product_id);
			}
		</script>
		<script type="text/javascript" src="{{ asset('js/jquery-1.12.2.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/vendor.js') }}"></script>
		<script type="text/javascript" src="{{ elixir('js/main.js') }}"></script>
		<script type="text/javascript" src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
		@yield('scripts')
		@stack('scripts')
	</body>
</html>
