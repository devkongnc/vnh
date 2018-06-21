@extends('layout.base')

@section('content')

    <article class="search">
        {!! Breadcrumbs::render('search') !!}
        <h1><b>SEARCH</b></h1>
        <section class="wrap-search-box">
            @include('partials.search_box')
        </section>
        <section class="wrap-content-search">
            <div class="sub-title">@lang('search.description')</div>
            <div class="wrap-list-search hidden-xs">
                <div class="fucnt-search">
                    <input placeholder="{{ trans('search.placeholder') }}" /> <button type="submit"><span class="icon-search"></span></button>
                </div>
                @include('partials.categories_list', ['categories' => $categories])
            </div>
        </section>
    </article>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(".three-grid .images").slick({});
            $('.selectpicker').selectpicker();
            $('#list-view').change(function(){
                $("#grid-target").removeClass('thumbnail-view');
                $("#grid-target").addClass("list-view");
                $("#grid-target").find('.images').slick('slickSetOption', 'speed', 500, true);
            });
            $('#thumbnail-view').change(function(){
                $("#grid-target").removeClass("list-view");
                $("#grid-target").addClass('thumbnail-view');
                $("#grid-target").find('.images').slick('slickSetOption', 'speed', 500, true);
            });
        });
    </script>
@endsection
