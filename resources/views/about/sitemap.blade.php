@extends('layout.base')

@section('content')
    <article class="sitemap about">
        {!! Breadcrumbs::render('sitemap') !!}
        <h1>@lang('menu.sitemap')</h1>
        <section class="sitemap-wrapper">
            <a href="{{ route('home') }}" class="btn-homepage">@lang('menu.home')</a>
            <div class="list-sitemap">
                <div class="col-sitemap">
                    <h3>@lang('front.sitemap.property')</h3>
                    <div class="text-col">
                        <p><a href="{{ action('HomeController@searchForm') }}">@lang('menu.search advanced')</a></p>
                        <p><a href="{{ action('RealEstateController@index') }}">@lang('menu.arrival')</a></p>
                        <p><a href="{{ action('CategoryController@index') }}">@lang('menu.categories')</a></p>
                        <p><a href="{{ action('ApartmentController@index') }}">@lang('menu.apartments')</a></p>
                    </div>
                    <h3><a href="{{ action('ReviewController@index') }}">@lang('front.sitemap.saigon review')</a></h3>
                </div>
                <div class="col-sitemap">
                    <h3><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[3]->permalink) }}">{{ $pages_by_id[3]->title }}</a></h3>
                    <div class="text-col">
                        @foreach ([2, 7, 4, 6, 5, 12, 13] as $i)
                            <p><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[$i]->permalink) }}">{{ $pages_by_id[$i]->title }}</a></p>
                        @endforeach
                    </div>
                </div>
                <div class="col-sitemap">
                    <h3><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[1]->permalink) }}">{{ $pages_by_id[1]->title }}</a></h3>
                    <div class="text-col">
                        @foreach ([10, 8, 9, 11] as $i)
                            <p><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[$i]->permalink) }}">{{ $pages_by_id[$i]->title }}</a></p>
                        @endforeach
                         <p><a href="{{ url('/company/sitemap') }}">@lang('menu.sitemap')</a></p>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
