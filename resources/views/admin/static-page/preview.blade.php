@extends('about.base')

@section('styles')
	<style type="text/css">
		{!! $data->css !!}
	</style>
@endsection

@section('about-content')
    <article class="page-{{ str_replace('/', '-', $page->permalink) }} page-{{ $page->id }} page-content">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="#">{{ $data->title }}</a>
        </div>
        {!! $data->html !!}
    </article>
@endsection
