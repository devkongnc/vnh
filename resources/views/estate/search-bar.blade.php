<input type="hidden" id="keyword" name="keyword" value="{{ !empty(Request::get('keyword')) ? Request::get('keyword') : '' }}" placeholder="ID、キーワード" />
<li>
    <a>エリア</a>
    <ul class="search-condition-item price-condition">
        <li>
            <div>
                <label>@lang('search.unit-price')</label>
                <div>
                    <div class="form-field2">
                        <input type="text" id="price-min" class="input-min-price num_only" value="{{$price[0]}}">
                        ~
                        <input type="text" id="price-max" class="input-max-price num_only" value="{{$price[1]}}"> $
                    </div>
                    <div class="form-field slider-class">
                        <input class="range-slider" type="hidden" name="term[price]" value="{{$price[0]}},{{$price[1]}}"/>
                    </div>
                </div>
                <div class="search-condition-navigation">
                    <button type="reset">Clear</button>
                    <button type="submit">Apply</button>
                </div>
            </div>
        </li>
    </ul>
</li>
<li>
    <a>㎡単価</a>
    <ul class="search-condition-item size-condition">
        <li>
            <div>
                <label>@lang('search.unit-area')</label>
                <div class="form-field2">
                    <input type="text" id="area-min" class="input-min-area num_only" value="{{$size[0]}}">
                    ~
                    <input type="text" id="area-max" class="input-max-area num_only" value="{{$size[1]}}"> ㎡
                </div>
                <div class="form-field range2 slider-class">
                    <input class="range-slider2" type="hidden" name="term[size]" value="{{$size[0]}},{{$size[1]}}"/>
                </div>
                <div class="search-condition-navigation">
                    <button type="reset">Clear</button>
                    <button type="submit">Apply</button>
                </div>
            </div>
        </li>
    </ul>
</li>
<li>
    <a>面積</a>
    <ul class="search-condition-item area-condition">
        <li>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownselect3"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('search.multiple-choice')
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownselect2">
                    @foreach($selected as $key => $term)
                        @if ($key == "area")
                            @foreach($term['values'] as $index => $value)
                                <li><label class="small"
                                       data-value="{!! \App\Term::getLocaleValue($value) !!}"
                                       tabIndex="-1"><input type="checkbox" name="term[area][]"
                                                            {{ (isset($terms[$key]) and in_array($index, $terms[$key])) ? ' checked' : '' }} value="{{ $index }}"/>&nbsp;{!! \App\Term::getLocaleValue($value) !!}
                                        </label>
                                    </li>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
                <div class="search-condition-navigation">
                    <button type="reset">Clear</button>
                    <button type="submit">Apply</button>
                </div>
            </div>
        </li>
    </ul>
</li>
<input type="hidden" id="ne_lat" name="ne_lat" value="">
<input type="hidden" id="ne_lng" name="ne_lng" value="">
<input type="hidden" id="sw_lat" name="sw_lat" value="">
<input type="hidden" id="sw_lng" name="sw_lng" value="">


{{--<div class="row">--}}
    {{--<div class="form-field">--}}
        {{--<div class="dropdown">--}}
            {{--<input type="text" value="" placeholder="ID、キーワード" />--}}
        {{--</div>--}}
        {{----}}
    {{--</div>--}}
{{--</div>--}}


