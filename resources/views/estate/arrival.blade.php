@extends('layout.base')

@section('content')
    <article id="content">
        {!! Breadcrumbs::render('arrival') !!}
        <div class="wrapper-arrival-head">
            <div class="house-new-head">
                <div class="box-arrival">
                    @lang('entity.arrival.today')
                    <span>{{ $today_estates->count() }}</span>
                    @lang('entity.arrival.item')
                </div>
                <div class="title-arrival">
                    <h1 class="text-uppercase">New-Arrival</h1>
                    <div class="subtitle">@lang('entity.arrival.description')</div>
                    <div class="note-arrival">@lang('entity.arrival.note')</div>
                </div>
            </div>
        </div>
        <div class="search-result-viewer">
            <div class="pagination-wrapper">
                {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($estates))->render() !!}
            </div>
            <div class="condition-actions text-right">
                <label for="order-type">@lang('front.sort by')：</label>
                <select class="selectpicker" id="order-type">
                    @foreach ((array) trans('search.order') as $key => $value)
                        <option value="{{ $key }}" {{ $order === $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <div class="btn-group hidden-xs" data-toggle="buttons">
                    <label class="btn">
                        <input type="radio" name="options" id="thumbnail-view" autocomplete="off"> <i class="fa fa-th-large fa-lg"></i>
                    </label>
                    <label class="btn">
                        <input type="radio" name="options" id="list-view" autocomplete="off"> <i class="fa fa-align-justify fa-lg"></i>
                    </label>
                </div>
            </div>
        </div>
        @unless ($today_estates->count() === 0 or (Request::has('page') and (int) Request::get('page') >= 2))
            <div style="margin-bottom: 30px">
                <div class="title-block clearfix" style="font-size: 1.2rem;">
                    <h5 class="title-text {{$current_locale }}" style="font:700 1.9rem Century Gothic,sans-serif">
                        @lang('entity.today_properties')
                    </h5>
                </div>
                @include('partials.three-grid', ['items' => $today_estates, 'today_estates' => true])
            </div>
        @endunless
        <div class="title-block clearfix" style="font-size: 1.2rem;">
            <h5 class="title-text {{$current_locale }}" style="font:700 1.9rem Century Gothic,sans-serif">
                @lang('entity.week_properties')
            </h5>
        </div>
        @include('partials.three-grid', ['items' => $estates])
        <div class="pagination-wrapper">
            {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($estates))->render() !!}
        </div>
    </article>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#order-type").change(function() {
                window.location.replace('{{ URL::action('RealEstateController@index') }}?order=' + $(this).val());
            });
        });
    </script>
@endpush
