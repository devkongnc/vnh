<!DOCTYPE html>
<html amp lang="{{ $current_locale }}">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="Content-Type" content="text/html"/>
	    <meta http-equiv="Content-Language" content="{{ $current_locale }}"/>
	    <meta name="viewport" content="{{ Cookie::get('vnh_desktop', 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1') }}">
	    <meta name="format-detection" content="telephone=no">
	    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>
	    {!! SEO::generate(true) !!}
	    {{-- <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:400,500"> --}}
		{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts_'. $current_locale . '.css') }}"> --}}
	    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	    <!-- amp -->
	    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
	    <!-- !amp -->
	    @yield('styles')
	    <script async src="https://cdn.ampproject.org/v0.js"></script>
	    @yield('script-async')
	</head>
	<body class="{{ $current_locale }}">
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
		<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
		<script type="text/javascript" src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
		@yield('scripts')
		@stack('scripts')
	</body>
</html>
