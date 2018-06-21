@extends('layout.base')

@section('content')
    <article id="content" class="tower">
        {!! Breadcrumbs::render('apartments') !!}
        <form id="apartment-area" action="{{ Request::url() }}" method="GET" class="tower-title" novalidate>
            <h1><b>HIGH-RISE APARTMENT</b></h1>
            <p><b>@lang('entity.apartment.description')</b></p>
            <select name="area" class="selectpicker" required="">
                <option value="">@lang('entity.apartment.selectpicker condo first option')</option>
                <option value="">@lang('entity.apartment.selectpicker condo first option')</option>
                @foreach(config('real-estate.area.values') as $index => $value)
                    <option value="{{ $index }}" {{ (Input::has('area') and (int) Input::get('area') === (int) $index) ? 'selected' : '' }}>{{ getLocaleValue($value) }}</option>
                @endforeach
            </select>
            {!! Form::text('name', request('name', ''), ['placeholder' => trans('entity.apartment.search_name')]) !!}
            {!! Form::submit(null, ['hidden' => true]) !!}
        </form>
        <ul class="tower-list list">
            @foreach($apartments as $i => $apartment)
                <li class="tower-list-item">
                    <img src="{{ $apartment->feature_image }}" class="img-responsive">
                    <div class="gray-overlay"></div>
                    <div class="title" >
                        <small class="single-line text-uppercase" style="margin-bottom: 10px">{{ getLocaleValue(config("real-estate.area.values.{$apartment->area}")) }}</small>
                        <a class="" style="line-height: 22px" href="{{ URL::action('ApartmentController@show', $apartment->permalink) }}">
                            @if (strpos($apartment->title, '<br>') !== false)
                                {!!  explode("<br>", $apartment->title)[0]."<br><span style='font-size: 1.3rem'>".explode("<br>", $apartment->title)[1]."</span>" !!}
                            @elseif(strpos($apartment->title, '<br/>') !== false)
                                {!!  explode("<br/>", $apartment->title)[0]."<br><span style='font-size: 1.3rem'>".explode("<br/>", $apartment->title)[1]."</span>" !!}
                            @elseif(strpos($apartment->title, '<br />') !== false)
                                {!!  explode("<br />", $apartment->title)[0]."<br><span style='font-size: 1.3rem'>".explode("<br />", $apartment->title)[1]."</span>" !!}
                            @else
                                {!!  $apartment->title !!}
                            @endif
                        </a>
                    </div>
                    @if ((int) $apartment->recommend > 0)
                        <a class="recommended active" href="{{ URL::action('ApartmentController@show', $apartment->permalink) }}">
                            <p>RECOMMEND<br/><span class="large">{{ $apartment->recommend }}</span></p>
                        </a>
                    @else
                        <a class="recommended" href="{{ URL::action('ApartmentController@show', $apartment->permalink) }}"></a>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="pagination-wrapper">
            {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($apartments))->render() !!}
        </div>
    </article>
@endsection

@section ('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.selectpicker').on('change', function() {
                if ($(this).val() === '') {
                    window.location = '{{ action('ApartmentController@index') }}';
                    return;
                }
                $('#apartment-area').submit();
            });
        });
    </script>
@stop