@extends('layout.base')

@section('styles')
	<style type="text/css">
		.top-bar-search {
			display: none;
		}
	</style>
@endsection

@section('content')
    <article class="page-not-found">
        <div class="content">
        	<div>
        		<img class="img-404" src="/images/bg-404.png">
	        	<h1>@lang('front.e404.title')</h1>
	        	<div class="desc-404">@lang('front.e404.desc')</div>
	        	<div class="alert-404">@lang('front.e404.alert')</div>
	        	<div class="way-fix">
	        		@lang('front.e404.detail')
	        	</div>
	        	<div class="link-other">
		        	<a href="/" class="btn-url">@lang('menu.home')</a>
		        	<a href="/sitemap" class="btn-url">@lang('menu.sitemap')</a>
	        	</div>
        	</div>
        </div>
    </article>
@endsection
