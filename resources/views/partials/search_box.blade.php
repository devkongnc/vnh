{!! Form::open(['action' => 'HomeController@search', 'id' => 'front-search', 'method' => 'GET']) !!}
<?php
$price = explode(",", isset($terms['price']) ? $terms['price'] : '0,500000');
$size = explode(",", isset($terms['size']) ? $terms['size'] : '0,5000');
if (!isset($position_search)) {
    $position_search = 'banner';
}
?>
<div class="advanced-search {{ if_route(['home']) ? '' : 'active' }}">
    @if($position_search == 'banner')
        <div class="logo-ho"><img src="{{ asset('images/new-layout/logo-ho.png') }}"></div>
    @endif
    <div class="range-section">
        <form>
            <div class="row">
                <label>@lang('search.area')</label>
                <div class="form-field">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownselect2"
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
    </div>

    <div class="search-gr">
        <label>@lang('search.hits-number')</label>
        <h2 id="total-estate">{{ isset($search_estates) ? $search_estates->total() : $total_estate }}</h2>
        <button type="submit" class="img-button">
            <a href="#" class="search-circle-btn"><img src="{{ asset('images/new-layout/icon-search.png') }}"></a>
        </button>
    </div>
</div>
{!! Form::close() !!}

<script>
    $(document).ready(function () {
        var price_max_search = '{{ $price[1] }}';
        var price_min_search = '{{ $price[0] }}';
        var size_max_search = '{{ $size[1] }}';
        var size_min_search = '{{ $size[0] }}';

        function ajaxSearch() {
            var frontSearch = $("form[id='front-search']");
            $.ajax({
                url: frontSearch.attr('action'),
                data: frontSearch.serialize(),
                processData: false,
                type: 'get',
                success: function (data) {
                    $("h2[id='total-estate']").text(data);
                }
            });
        }

        //dropdown checekbox//
        var options = [];
        $('.dropdown-menu a').on('click', function (event) {
            var $target = $(event.currentTarget),
                val = $target.attr('data-value'),
                $inp = $target.find('input'),
                idx;

            if ((idx = options.indexOf(val)) > -1) {
                options.splice(idx, 1);
                setTimeout(function () {
                    $inp.prop('checked', false);
                    ajaxSearch();
                }, 0);
            } else {
                options.push(val);
                setTimeout(function () {
                    $inp.prop('checked', true);
                    ajaxSearch();
                }, 0);
            }
            $(event.target).blur();
            return false;
        });

        $('.range-slider').jRange({
            from: 0,
            to: price_max_search,
            step: 1,
            scale: [price_min_search, price_max_search],
            format: '%s',
            width: 300,
            showLabels: true,
            isRange: true,
            ondragend: function (data) {
                var range = data.split(",");
                $("#price-min").val(range[0]);
                $("#price-max").val(range[1]);
                ajaxSearch();
            },
            onbarclicked: function (data) {
                var range = data.split(",");
                $("#price-min").val(range[0]);
                $("#price-max").val(range[1]);
                ajaxSearch();
            }
        });
        $('.range-slider2').jRange({
            from: 0,
            to: size_max_search,
            step: 1,
            scale: [size_min_search, size_max_search],
            format: '%s',
            width: 300,
            showLabels: true,
            isRange: true,
            ondragend: function (data) {
                var range = data.split(",");
                $("input#area-min").val(range[0]);
                $("input#area-max").val(range[1]);
                ajaxSearch();
            },
            onbarclicked: function (data) {
                var range = data.split(",");
                $("input#area-min").val(range[0]);
                $("input#area-max").val(range[1]);
                ajaxSearch();
            }
        });
        $(".num_only").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl/cmd+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+C
                (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+X
                (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $("#price-min").keyup(function (e) {
            setTimeout(function () {
                var price_min = parseInt($("#price-min").val());
                var price_max = parseInt($("#price-max").val());
                if (isNaN(price_min)) {
                    price_min = 0;
                }

                if (isNaN(price_max)) {
                    price_max = price_max_search;
                }

                if (price_min <= price_max && price_min <= 5000) {
                    $('.range-slider').jRange('setValue', price_min + "," + price_max);
                    ajaxSearch();
                }

            }, 100);

        });

        $("#price-min").change(function (e) {
            var price_min = parseInt($("#price-min").val());
            if (isNaN(price_min)) {
                $("#price-min").val("0");
            }

        });

        $("#price-max").change(function (e) {
            var price_max = parseInt($("#price-max").val());
            if (isNaN(price_max)) {
                $("#price-max").val(price_max_search);
            }

        });

        $("#price-max").keyup(function (e) {
            setTimeout(function () {
                var price_min = parseInt($("#price-min").val());
                var price_max = parseInt($("#price-max").val());
                if (isNaN(price_min)) {
                    price_min = 0;
                }

                if (isNaN(price_max)) {
                    price_max = price_max_search;
                }

                if (price_max >= price_min && price_max <= price_max_search) {
                    $('.range-slider').jRange('setValue', price_min + "," + price_max);
                    ajaxSearch();
                }

            }, 100);

        });

        $("#area-min").keyup(function (e) {
            setTimeout(function () {
                var area_min = parseInt($("#area-min").val());
                var area_max = parseInt($("#area-max").val());
                if (isNaN(area_min)) {
                    area_min = 0;
                }

                if (isNaN(area_max)) {
                    area_max = size_max_search;
                }

                if (area_min <= area_max && area_min <= size_max_search) {
                    $('.range-slider2').jRange('setValue', area_min + "," + area_max);
                    ajaxSearch();
                }

            }, 100);

        });

        $("#area-min").change(function (e) {
            var area_min = parseInt($("#area-min").val());
            if (isNaN(area_min)) {
                $("#area-min").val("0");
            }

        });

        $("#area-max").change(function (e) {
            var area_max = parseInt($("#area-max").val());
            if (isNaN(area_max)) {
                $("#area-max").val("0");
            }
        });

        $("#area-max").keyup(function (e) {
            setTimeout(function () {
                var area_min = parseInt($("#area-min").val());
                var area_max = parseInt($("#area-max").val());
                if (isNaN(area_min)) {
                    area_min = 0;
                }

                if (isNaN(area_max)) {
                    area_max = size_max_search;
                }

                if (area_max >= area_min && area_max <= size_max_search) {
                    $('.range-slider2').jRange('setValue', area_min + "," + area_max);
                    ajaxSearch();
                }

            }, 100);

        });
    });
</script>
