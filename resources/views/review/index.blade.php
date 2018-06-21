@extends('layout.base')

@section('content')
    <article id="content">
        @if (count($categories) == 1)
            {!! Breadcrumbs::render('review-category', $categories[0]) !!}
        @else
            {!! Breadcrumbs::render('reviews') !!}
        @endif
        <div class="review-title">
            <div class="note-wrapper {{ LaravelLocalization::getCurrentLocale() }}">
                <div class="note review-categories-wrapper">
                @foreach ((array) trans('admin.review.categories') as $index => $value)
                    <p><a href="{{ action('ReviewController@category', [config('override.category.' . $index)]) }}" data-category="{{ $index }}" class="{{ in_array($index, $categories, true) ? 'text-primary' : '' }}"><i class="icon-{{ trans('admin.review.categories icon.' . $index) }}" aria-hidden="true"></i> {{ $value }}</a></p>
                @endforeach
                </div>
            </div>
            <div class="review-logo">
                <a href="{{ URL::action('ReviewController@index') }}"><img class="pull-left" src="{{ asset('images/review_logo.svg') }}" width="177"></a>
            </div>
            <div class="review-introduction">
                <p class="introduction">@lang('entity.review.description')</p>
            </div>
        </div>
    </article>
    {{--<div class="review-search-wrapper">--}}
        {{--<form action="{{ action('ReviewController@search') }}" method="GET" class="fucnt-search">--}}
            {{--<input name="title" value="{{ Input::get('title') }}" placeholder="@lang('search.placeholder')" required=""> <button type="submit"><span class="icon-search"></span></button>--}}
        {{--</form>--}}
    {{--</div>--}}
    <div id="review-ajax">
        @include('review.list')
    </div>
@endsection
