@extends('layout.base')

@section('content')
    <?php
    $price = explode(",", isset($terms['price']) ? $terms['price'] : '0,100');
    $size = explode(",", isset($terms['size']) ? $terms['size'] : '0,3000');
    ?>
    <div class="head-search">
        <div class="content-l">
            <form>
                <ul class="bt-group-search-condition">
                    {{--@include('estate.search-bar', ['search_estates' => $search_estates, 'price' => $price, 'size' => $size])--}}
                    <li class="search-bar-number-hits">@lang('front.number of hits') <strong>{{ $search_estates->total() }}</strong></li>
                </ul>
            </form>
            <a href="#search-map" id="btn-open-map" class="search-map">
                <img src="{{ asset('images/new-layout/icon-map.png') }}"> MAP
            </a>
        </div>
    </div>

    <div class="content-l">
        <div id="product-result" class="list-map">
            @include('partials.three-grid', ['items' => $search_estates])
            {{-- paginate --}}
            {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($search_estates))->render() !!}
        </div>
    </div>

@endsection
