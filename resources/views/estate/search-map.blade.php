@extends('layout.base')
@section('styles')
    <style>
        .bt-close-marker {
            margin-top: 14px;
        }
        .row-map {
            float: left;
        }
    </style>
@stop
@section('content')
    <?php
    $price = explode(",", isset($terms['price']) ? $terms['price'] : '0,100');
    $size = explode(",", isset($terms['size']) ? $terms['size'] : '0,3000');
    ?>
    <div class="head-search">
        <div class="content-l">
            <form>
                <ul class="bt-group-search-condition">
                    @include('estate.search-bar', ['search_estates' => $search_estates, 'price' => $price, 'size' => $size])
                    <li class="search-bar-number-hits">@lang('front.number of hits') <strong>{{ $search_estates->total() }}</strong></li>
                </ul>
            </form>
            <a href="#close-map" id="btn-close-map" class="search-map">
                <img src="{{ asset('images/new-layout/icon-map-close.png') }}"> MAP
            </a>
        </div>
    </div>

    <div class="content-l">
        <div id="product-result" class="list-map">
            <?php
            $location = array();
            if (!empty($push_maps)) {
                foreach ($push_maps as $key => $value) {
                    $location[] = [
                        $value->price.(!empty($value->price_max) ?'~'.$value->price_max:''),
                        $value->lat,
                        $value->lng,
                        $key,
                        $value->product_id,
                        url(action('RealEstateController@show', $value->product_id)),
                        $value->title,
                        img_exists($value->resource->path),
                    ];
                }
            }
            ?>
            <div class="row row-map">
                <!-- show grid -->
                <div class="house-list-scroll first-load second-load">
                    @include('partials.three-grid-map', ['items' => $search_estates])
                </div>
            </div>
            {{-- show maps --}}
            <div class="house-list-map">
                <div id="map-result"></div>
            </div>
        </div>
    </div>
    <a id="show_map_button" class="">
        <span class="fa-stack">
            <img src="{{ asset('/images/new-layout/icn-bt-maps.png') }}">
        </span>
    </a>
@stop

@section('scripts')
    <script type="text/javascript">
        var locations = JSON.parse('{!! json_encode($location) !!}');
        var frontSearch = $(".search-header form");
        var lst_data_content = $('.house-list-scroll');
        var infowindow = {};
        var priority = '{{ (!empty($data_request) ? (!empty($data_request['ne_lat']) ? 1 : 0) : 0) }}';
        var listenerHandle_bounds_changed;

        if(!locations.length) {
            display_empty_data();
        }

        // show maps
        function initMap() {
            var x = 0;
            var y = 0;
            var max_lat = 0;
            var min_lat = 0;
            var max_lng = 0;
            var min_lng = 0;
            if (priority == 0) {
                for (var i = 0; i < locations.length; i++) {
                    // khai báo giá trị
                    var lats = parseFloat(locations[i][1]);
                    var lngs = parseFloat(locations[i][2]);

                    x += lats / (locations.length);
                    y += lngs / (locations.length);

                    if (max_lat < lats) {
                        max_lat = lats;
                    }
                    if (min_lat > lats || min_lat === 0) {
                        min_lat = lats;
                    }
                    if (max_lng < lngs) {
                        max_lng = lngs;
                    }
                    if (min_lng > lngs || min_lng === 0) {
                        min_lng = lngs;
                    }
                }
            } else {
                max_lat = '{{ (!empty($data_request) ? (!empty($data_request['ne_lat']) ? $data_request['ne_lat'] : 0) : 0) }}';
                min_lat = '{{ (!empty($data_request) ? (!empty($data_request['sw_lat']) ? $data_request['sw_lat'] : 0) : 0) }}';
                max_lng = '{{ (!empty($data_request) ? (!empty($data_request['ne_lng']) ? $data_request['ne_lng'] : 0) : 0) }}';
                min_lng = '{{ (!empty($data_request) ? (!empty($data_request['sw_lng']) ? $data_request['sw_lng'] : 0) : 0) }}';
            }

            var center_lat = (max_lat + min_lat) / 2;
            var center_lng = (max_lng + min_lng) / 2;

            var getBound = new google.maps.LatLngBounds();
            getBound.extend(new google.maps.LatLng(max_lat, max_lng));
            getBound.extend(new google.maps.LatLng(min_lat, min_lng));

            var myLatLng = {lat: center_lat, lng: center_lng};
            var map = new google.maps.Map(document.getElementById('map-result'), {
                zoom: 8,
                center: myLatLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            map.fitBounds(getBound);

            // call marker
            setMarkers(map);

            //after map loaded
            map.addListener('tilesloaded', function () {
                add_style_for_map();
            });

            // bounds_changed
            listenerHandle_bounds_changed = map.addListener('bounds_changed', function () {
                map_drag_zoom(map);
            });
        }

        function map_drag_zoom(map) {
            //console.log(map.getZoom());
            if ($('.first-load').length) {
                if (priority == 1) {
                    var current_zoom_reload = map.getZoom();
                    if(current_zoom_reload < 2) {
                        current_zoom_reload = 2;
                    }
                    map.setZoom(current_zoom_reload+1);
                }
                $('.first-load').removeClass("first-load");
            } else {
                if ($('.second-load').length) {
                    $('.second-load').removeClass("second-load");
                    google.maps.event.removeListener(listenerHandle_bounds_changed);

                    // drag event, zoom event
                    map.addListener('dragend', function () {
                        map_drag_zoom(map);
                    });
                    // zoom event
                    map.addListener('zoom_changed', function () {
                        map_drag_zoom(map);
                    });
                } else {
                    if( map.getZoom() <= 2) {
                        map.setZoom(3);
                    }
                    var bounds = map.getBounds();
                    var ne = bounds.getNorthEast();
                    var sw = bounds.getSouthWest();
                    $('input#ne_lat').val(ne.lat());
                    $('input#ne_lng').val(ne.lng());
                    $('input#sw_lat').val(sw.lat());
                    $('input#sw_lng').val(sw.lng());
                    $.ajax({
                        url: 'data-map-ajax',
                        data: frontSearch.serialize(),
                        type: 'get',
                        dataType: 'html',
                        success: function (response) {
                            reload_list_estate(response, map);
                        }
                    });
                }
            }
        }

        function reload_list_estate(response, map) {
            // change url address - not reload
            ChangeUrl(document.title, '{{ url(action('SearchMapController@search')) }}?' + frontSearch.serialize());

            if (response != '') {
                lst_data_content.html(response);
                add_style_for_data();

                if ($('input[name="page_map_data"]').length) {
                    locations = JSON.parse($('input[name="page_map_data"]').val());
                    $('.number_estate_result').html($('input[name="map_data_total"]').val());
                    setMarkers(map);
                    add_style_for_map();
                }
            } else {
                display_empty_data();
            }
        }

        function display_empty_data() {
            $(".row-map > .map-list-pagi").remove();
            lst_data_content.html('<div class="no-data-map">{!!  trans('front.txt_no_result_map_data') !!}</div>');
            $(".house-list-scroll > div.no-data-map").css('margin-top','0');
        }

        // add marker
        function setMarkers(map) {
            $.each(infowindow, function (i, e) {
                e.close();
            });
            infowindow = {};

            for (var i = 0; i < locations.length; i++) {
                var lats = parseFloat(locations[i][1]);
                var lngs = parseFloat(locations[i][2]);
                var price = locations[i][0].toString();
                var nums = locations[i][3];
                var id = locations[i][4];
                var url = locations[i][5];
                var title = locations[i][6];
                var thumbnail = locations[i][7];
                var content = '<div class="map-mark-details dt_'+id+'" estate_url="' + url + '">' +
                    '<div class="map-mark-thumbnail"><div><img src="'+thumbnail+'" /></div></div>' +
                    '<div class="map-mark-title">'+title+'</div>' +
                    '<div class="map-mark-price"><strong>'+price+'</strong> USD/㎡</div>' +
                    '</div>';

                infowindow[i] = (new google.maps.InfoWindow({
                    position: {lat: lats, lng: lngs},
                    map: map,
                    content: '<div id="_item' + id + '" est_id="' + id + '" class="maps-mark-item"><a class="map-mark-placeholder" onclick="open_mark_detail(\'' + id + '\')">' + price + '$</a>'+content+'</div>',
                    zIndex: nums
                }));
            }

        }

        function open_mark_detail(product_id) {
            $('.map-mark-details').hide();
            $('.dt_'+product_id).fadeIn();
        }

        function add_style_for_map() {
            var marker_item = $(".gm-style-iw").parent();
            //remove close button
            marker_item.find('>div:eq(2)').css("display", "none");

            //hover marker
            marker_item.hover(function () {
                //marker_item.parent().find('>div').css("opacity","0.4");
                $(this)
                //.css("opacity","1")
                    .css('z-index', '21')
                    .find('div:eq(5), div:eq(7), div:eq(8)').css("background-color", "rgb(251, 168, 73)");
                var est_id = $(this).find('.maps-mark-item').attr('est_id');
                $("#" + est_id).addClass('hover_maps');

            }, function () {
                //marker_item.parent().find('>div').css("opacity","1");
                $(this)
                    .css('z-index', $(this).index())
                    .find('div:eq(5), div:eq(7), div:eq(8)').css("background-color", "rgb(255, 255, 255)");
                var est_id = $(this).find('.maps-mark-item').attr('est_id');
                $("#" + est_id).removeClass('hover_maps');
            });

            $(".map-mark-details").click(function () {
                var estate_url = $(this).attr('estate_url');
                window.open(estate_url);
            });

        }

        function add_style_for_data() {
            //hover list left
            $(".house-blk").hover(function () {
                var p_id = $(this).attr('id');
                var temp = $('#_item' + p_id).closest(".gm-style-iw").parent();
                temp.find('div:eq(5), div:eq(7), div:eq(8)').css("background-color", "rgb(251, 168, 73)");
                temp.parent().find('>div').css("opacity", "0.4");
                temp.css("opacity", "1").css('z-index', '21');
            }, function () {
                var p_id = $(this).attr('id');
                var temp = $('#_item' + p_id).closest(".gm-style-iw").parent();
                temp.find('div:eq(5), div:eq(7), div:eq(8)').css("background-color", "rgb(255, 255, 255)");
                temp.css('z-index', $(this).index())
                    .parent().find('>div').css("opacity", "1");
            });

            if ($(".house-list-scroll > .map-list-pagi").length) {
                if ($(".row-map > .map-list-pagi").length) {
                    $(".row-map > .map-list-pagi").remove();
                }
                $(".house-list-scroll > .map-list-pagi").prependTo(".row-map");
            } else {
                var paging = $('input[name="map_data_last_page"]').val();
                if(paging == 0) {
                    $(".row-map > .map-list-pagi").remove();
                    $(".house-list-scroll>div:first-child").css('margin-top','0');
                }
            }

            $.each($('.pagination-blk').parent().find('a'), function () {
                var change_href = $(this).attr("href");
                $(this).attr("href", "?" + change_href.split('?')[1]);
            });


            $('.house-carousel').owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                navText: ["", ""],
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });
        }

        function ChangeUrl(title, url) {
            if (typeof (history.pushState) != "undefined") {
                var obj = {Title: title, Url: url};
                history.pushState(obj, obj.Title, obj.Url);
            } else {
                alert("Browser does not support HTML5.");
            }
        }

        var x = $('.house-list-scroll');
        var map_elem = $('.house-list-map');
        var map_elem_height = 0;
        var mark_elem  = 0;
        var hearder_height = 0;

        $(document).ready(function () {
            initMap();
            add_style_for_data();
            mark_elem = x.offset().top;
            hearder_height = $('.header').outerHeight()+$('.head-search').outerHeight();
            map_height_function();
            map_elem_height = map_elem.height();
        });

        function map_height_function() {
            if ($(document).width()>767) {
                if ($(document).scrollTop() > 0 && $(document).scrollTop() <= 200) {
                    map_elem.css('height', 'calc(100vh - '+(hearder_height-$(document).scrollTop())+'px)')
                } else if ($(document).scrollTop() > 200) {
                    map_elem.css('height', 'calc(100vh - 60px)')
                } else {
                    map_elem.css('height', 'calc(100vh - '+hearder_height+'px)')
                }
            } else if ($(document).width()<=767) {
                if ($(document).scrollTop() > 0 && $(document).scrollTop() <= hearder_height) {
                    map_elem.css('height', 'calc(100vh - '+(hearder_height-$(document).scrollTop()+$('.menu-fix').outerHeight())+'px)')
                } else if ($(document).scrollTop() > hearder_height) {
                    map_elem.css('height', 'calc(100vh - '+$('.menu-fix').outerHeight()+'px)')
                } else {
                    map_elem.css('height', 'calc(100vh - ' + (hearder_height + $('.menu-fix').outerHeight()) + 'px)');
                }
            }
        }



        $(window).scroll(function () {
            map_height_function();
        });

        $(window).resize(function () {
            map_height_function();
        });

    </script>
@stop