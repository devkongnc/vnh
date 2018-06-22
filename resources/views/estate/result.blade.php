@extends('layout.base')

@section('content')
<div class="head-search">
    <div class="content-l">
        <ul>
            @foreach($terms as $key => $term)
            {{-- */ $data = config("real-estate.{$key}"); /* --}}
                @if ($key === 'area')
                    @foreach ($term as $value)
                        <li><a href="#">{{ getLocaleValue($data['values'][$value]) }}</a></li>
                    @endforeach
                @endif
            @endforeach
            <li>@lang('front.number of hits') <strong>{{ $search_estates->total() }}</strong></li>
        </ul>
        <a href="#" id="btn-open-map" class="search-map">
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

<script type="text/javascript">
    var frontSearch = $("form[id='front-search']");
    $('#btn-open-map').click(function(){
        // alert('hello');
        $.ajax({
            url: 'search-map',
            data: frontSearch.serialize(),
            processData: false,
            type: 'get',
            success: function (response) {
                $('#product-result').html(response);
                console.log(response);
            }
        });
    });
</script>

@endsection
