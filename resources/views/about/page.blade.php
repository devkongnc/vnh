@extends('about.base')

@section('styles')
	<style type="text/css">
		{!! $page->css !!}
	</style>
@endsection

@section('about-content')
    <article class="page-{{ $data->permalink }}">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="{{ route('page', $page->permalink) }}">{{ $page->title }}</a>
        </div>
        {!! $page->html !!}
    </article>
    <a class="btn btn-primary" href="{{ action('Admin\PageController@edit', $page->id) }}" role="button">@lang('admin.common.edit')</a>
@endsection
