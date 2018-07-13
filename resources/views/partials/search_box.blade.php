{!! Form::open(['action' => 'HomeController@search', 'id' => 'front-search', 'method' => 'GET']) !!}
<?php
$price = explode(",", isset($terms['price']) ? $terms['price'] : '0,5000');
$size = explode(",", isset($terms['size']) ? $terms['size'] : '0,3000');
if (!isset($position_search)) {
    $position_search = 'banner';
}
?>
<div class="advanced-search {{ if_route(['home']) ? '' : 'active' }}">
    <div class="range-section">
        <form>
            <div class="row">
                <div class="form-field">
                    <div class="dropdown">
                        <input type="text" value="" placeholder="ID、キーワード" />
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownselect3"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('search.multiple-choice')
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownselect2">
                            @foreach($selected as $key => $term)
                                @if ($key == "area")
                                    @foreach($term['values'] as $index => $value)
                                        <li><a href="#" class="small"
                                               data-value="{!! \App\Term::getLocaleValue($value) !!}"
                                               tabIndex="-1"><input type="checkbox" name="term[area][]"
                                                                    {{ (isset($terms[$key]) and in_array($index, $terms[$key])) ? ' checked' : '' }} value="{{ $index }}"/>&nbsp;{!! \App\Term::getLocaleValue($value) !!}
                                            </a></li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <label>@lang('search.unit-price')</label>
                <div class="form-field">
                    <input class="range-slider" type="hidden" name="term[price]" value="{{$price[0]}},{{$price[1]}}"/>
                </div>
                <div class="form-field2">
                    <input type="text" id="price-min" class="input-min-price num_only" value="{{$price[0]}}">
                    ~
                    <input type="text" id="price-max" class="input-max-price num_only" value="{{$price[1]}}"> $
                </div>
            </div>
            <div class="row">
                <label>@lang('search.unit-area')</label>
                <div class="form-field range2">
                    <input class="range-slider2" type="hidden" name="term[size]" value="{{$size[0]}},{{$size[1]}}"/>
                </div>
                <div class="form-field2">
                    <input type="text" id="area-min" class="input-min-area num_only" value="{{$size[0]}}">
                    ~
                    <input type="text" id="area-max" class="input-max-area num_only" value="{{$size[1]}}"> ㎡
                </div>
            </div>

            {{-- add zoom latlng --}}
            <input type="hidden" id="ne_lat" name="ne_lat" value="">
            <input type="hidden" id="ne_lng" name="ne_lng" value="">
            <input type="hidden" id="sw_lat" name="sw_lat" value="">
            <input type="hidden" id="sw_lng" name="sw_lng" value="">
        </form>
        <div><a href="#" class="quest-btn">30人規模オフィス面積の算出</a></div>
    </div>

    <div class="search-gr">
        <label>@lang('search.hits-number')</label>
        <h2 id="total-estate">{{ isset($search_estates) ? $search_estates->total() : $total_estate }}</h2>
        <button type="submit" class="img-button">
            <a href="#" class="search-circle-btn"><img src="{{ asset('images/new-layout/icon-search.png') }}"></a>
        </button>
        <button class="clear-form-search-btn" type="reset">@lang('search.reset')</button>
        <a href="#" class="special-btn">レンタルオフィスをご希望の方</a>
    </div>
</div>
{!! Form::close() !!}

