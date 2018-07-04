@extends('layout.base')

@section('content')
<div class="head-search">
    <div class="content-l">
        <ul>
            @foreach($terms as $key => $term)
                <?php $data = config("real-estate.{$key}"); ?>
                @if ($key === 'area')
                    @foreach ($term as $value)
                        <li><a href="#">{{ getLocaleValue($data['values'][$value]) }}</a></li>
                    @endforeach
                @endif
            @endforeach
            <li>@lang('front.number of hits') <strong>{{ $search_estates->total() }}</strong></li>
        </ul>
        <a href="#search-map"  id="btn-open-map" class="search-map">
            <img src="{{ asset('images/new-layout/icon-map.png') }}" > MAP
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
