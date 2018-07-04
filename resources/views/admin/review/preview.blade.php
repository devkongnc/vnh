@extends('layout.base')

@section('content')
    <article class="row" id="content">
        {!! Breadcrumbs::render('review', $review) !!}
        <div class="single-review row">
            <div class="left-section col-sm-3">
                <div class="review-stick">
                    <div class="navsingle-review">
                        <a href="{{ action('ReviewController@index') }}"><img src="{{ asset('images/review_logo.png') }}"/></a>
                        <p class="guarantee text-center">@lang('entity.review.description')</p>
                        <a href="{{ action('ReviewController@index') }}" class="border-button btn-block text-center"><b>@lang('entity.review.top')</b></a>
                        <form action="{{ action('ReviewController@search') }}" method="GET" class="fucnt-search">
                            <input name="title" value="" required=""> <button type="submit"><span class="icon-search"></span></button>
                        </form>
                        <div class="note {{ LaravelLocalization::getCurrentLocale() }}">
                        @foreach ((array) trans('admin.review.categories') as $index => $value)
                            <a href="{{ action('ReviewController@index', ['category' => $index]) }}" class="{{ in_array($index, $review->categories, true) ? 'text-primary' : '' }}"><i class="icon-{{ trans('admin.review.categories icon.' . $index) }}" aria-hidden="true"></i> {{ $value }}</a>
                        @endforeach
                        </div>
                        @if (!empty($review->user))
                        <div class="writer-information center-block">
                            <h3>WRITER</h3>
                            <img src="{{ asset('/images/favicon.png') }}" />
                            <p class="writer-name">Vietnamhouse</p>
                        </div>
                        @endif
                        <p class="text-center">
                            <a class="review-social" href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                            <a class="review-social" href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a class="review-social" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a class="review-social" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                        </p>
                    </div>
                </div>
            </div>
            <section class="right-section col-sm-9">
                <div class="row">
                    <address class="review-time col-sm-2 col-sm-push-10 text-right">{{ $review->timestampdot }}</address>
                    <h1 class="col-sm-10 col-sm-pull-2"><i class="icon-cake"></i> {{ $data->title }}</h1>
                </div>
                <div>
                    {!! $data->description !!}
                </div>
                <a href="{{ action('ReviewController@index') }}" class="visible-xs btn border-button btn-block">@lang('entity.review.top')</a>
            </section>
        </div>
    </article>
@endsection
