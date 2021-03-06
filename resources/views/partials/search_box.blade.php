{!! Form::open(['action' => 'HomeController@search', 'id' => 'front-search', 'method' => 'GET']) !!}
<?php
$price = explode(",", isset($terms['price']) ? $terms['price'] : '0,100');
$size = explode(",", isset($terms['size']) ? $terms['size'] : '0,3000');
if (!isset($position_search)) {
    $position_search = 'banner';
}
?>
<div class="mobile_search_top_toggle show-mobile">
    <img src="{{ asset('images/new-layout/icon-search-black.png') }}"/>
    &nbsp;<span>@lang('front.top_search_toggle')</span></div>
<div class="advanced-search {{ if_route(['home']) ? '' : 'active' }}">
    <div class="range-section">
        <div class="row">
            <div class="form-field">
                <div class="dropdown">
                    <input type="text" id="keyword" name="keyword"
                           value="{{ !empty(Request::get('keyword')) ? Request::get('keyword') : '' }}"
                           placeholder="@lang('search.placeholder')"/>
                </div>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle {{ (!empty($terms["area"])) ? 'selected_area' : '' }}" type="button" id="dropdownselect3"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(!empty($terms["area"]))
                            @lang('search.multiple-choice-selected')
                        @else
                            @lang('search.multiple-choice')
                        @endif
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownselect2">
                        @foreach($selected as $key => $term)
                            @if ($key == "area")
                                @foreach($term['values'] as $index => $value)
                                    <li><a href="#" class="small"
                                           data-value="{!! \App\Term::getLocaleValue($value) !!}"
                                           tabIndex="-1">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="term[area][]"
                                                           {{ (isset($terms[$key]) && in_array($index, $terms[$key])) ? ' checked' : '' }} value="{{ $index }}"/>
                                                    <span class="cr"><i
                                                                class="cr-icon glyphicon glyphicon-ok"></i></span>
                                                    &nbsp;{!! \App\Term::getLocaleValue($value) !!}
                                                </label>
                                            </div>
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
            <div class="form-field2">
                <input type="text" id="price-min" class="input-min-price num_only" value="{{$price[0]}}">
                ~
                <input type="text" id="price-max" class="input-max-price num_only" value="{{$price[1]}}"> $
            </div>
            <div class="form-field slider-class">
                <input class="range-slider" type="hidden" name="term[price]" value="{{$price[0]}},{{$price[1]}}"/>
            </div>
        </div>
        <div class="row">
            <label>@lang('search.unit-area')</label>
            <div class="form-field2">
                <input type="text" id="area-min" class="input-min-area num_only" value="{{$size[0]}}">
                ~
                <input type="text" id="area-max" class="input-max-area num_only" value="{{$size[1]}}"> ㎡
            </div>
            <div class="form-field range2 slider-class">
                <input class="range-slider2" type="hidden" name="term[size]" value="{{$size[0]}},{{$size[1]}}"/>
            </div>
        </div>

        {{-- add zoom latlng --}}
        <input type="hidden" id="ne_lat" name="ne_lat" value="">
        <input type="hidden" id="ne_lng" name="ne_lng" value="">
        <input type="hidden" id="sw_lat" name="sw_lat" value="">
        <input type="hidden" id="sw_lng" name="sw_lng" value="">
        <div class="contain_last_form_search hide-mobile"><a href="#" class="quest-btn">@lang('search.button_question')</a></div>
    </div>

    <div class="search-gr">
        <div>
            <label>@lang('search.hits-number')</label>
            <h2 id="total-estate">{{ isset($search_estates) ? $search_estates->total() : $total_estate }}</h2>
        </div>
        <button type="submit" class="img-button">
            <a href="#" class="search-circle-btn"><img src="{{ asset('images/new-layout/icon-search.png') }}"><span
                        class="show-mobile">@lang('search.bt_search')</span></a>
        </button>
        <button class="clear-form-search-btn" type="reset">@lang('search.reset')</button>
        <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/support/rental-office') }}"
           class="special-btn hide-mobile">@lang('search.button_link')</a>
    </div>
</div>
{!! Form::close() !!}


<style>
    .jrange-single{
        position: absolute;
        top: -35px;
        left: 50%;
        transform: translate(-50%,0);
        width: 60px;
        background: #fff;
        color: #333;
        border: 1px solid #000;
        padding: 5px;
        line-height: 9px;
        border-radius: 2px;
        text-align: center;
        font-size: 10px;
        font-weight: bold;
        display: none;
    }
    .jrange-single:before, .jrange-single:after{
        position: absolute;
        content: "";
        display: inline-block;
        border-bottom: 0;
    }
    .jrange-single:before{
        left: 20px;
        bottom: -7px;
        border-top: 7px solid #000;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
    }
    .jrange-single:after {
        left: 21px;
        bottom: -6px;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #fff;
    }

    .range2 .jrange-single{
        width: 70px;
    }
    .range2 .jrange-single:before{
        left: 24px;
    }
    .range2 .jrange-single:after {
        left: 25px;
    }
    .theme-green .back-bar .pointer-label{
        display: block;
    }
</style>

