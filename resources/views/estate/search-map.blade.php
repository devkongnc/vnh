@extends('layout.base')

@section('content')
    <div class="head-search">
        <div class="content-l">
            <ul>
                @foreach($terms as $key => $term)
                    <?php $data_config = config("real-estate.{$key}"); ?>
                    @if ($key === 'area')
                        @foreach ($term as $value)
                            <li><a href="#">{{ getLocaleValue($data_config['values'][$value]) }}</a></li>
                        @endforeach
                    @endif
                @endforeach
                <li>@lang('front.number of hits') <strong>{{ $search_estates->total() }}</strong></li>
            </ul>
            <a href="#" id="btn-close-map" class="search-map">
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
                        $value->price,
                        $value->lat,
                        $value->lng,
                        $key,
                        $value->product_id,
                        url(action('RealEstateController@show', $value->product_id)),
                    ];
                }
            }
            ?>
            @include('partials.three-grid-map', ['items' => $search_estates, 'location' => $location])
            {{-- paginate --}}
            {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($search_estates))->render() !!}
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        var locations = JSON.parse('{!! json_encode($location) !!}');

        // show maps
        function initMap() {
            var x = 0;
            var y = 0;
            var max_lat = 0;
            var min_lat = 0;
            var max_lng = 0;
            var min_lng = 0;
            for (var i = 0; i < locations.length; i++) {
                // khai báo giá trị
                var lats = parseFloat(locations[i][1]);
                var lngs = parseFloat(locations[i][2]);

                x += lats / (locations.length);
                y += lngs / (locations.length);

                if(max_lat < lats) { max_lat = lats;}
                if(min_lat > lats || min_lat === 0) { min_lat = lats;}
                if(max_lng < lngs) { max_lng = lngs;}
                if(min_lng > lngs || min_lng === 0) { min_lng = lngs;}
            }

            var center_lat = (max_lat - min_lat) / 2;
            var center_lng = (max_lng - min_lng) / 2;


            var myLatLng = {lat: center_lat, lng: center_lng};
            var map = new google.maps.Map(document.getElementById('map-result'), {
                zoom: 4,
                center: myLatLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var getBound = new google.maps.LatLngBounds();
            getBound.extend(new google.maps.LatLng(max_lat, min_lng));
            getBound.extend(new google.maps.LatLng(min_lat, max_lng));
            map.fitBounds(getBound);

            // call marker
            setMarkers(map);

            var frontSearch = $(".search-header form");

            // zoom event
            map.addListener('zoom_changed', function() {
                var bounds =  map.getBounds();
                var ne = bounds.getNorthEast();
                var sw = bounds.getSouthWest();
                $('#ne_lat').val(ne.lat());
                $('#ne_lng').val(ne.lng());
                $('#sw_lat').val(sw.lat());
                $('#sw_lng').val(sw.lng());
                //console.log('zoom:' + map.getZoom());

//                 $.ajax({
//                     url: 'search-map',
//                     data: frontSearch.serialize(),
//                     processData: false,
//                     type: 'get',
//                     success: function (response) {
//                         $('#product-result').html(response);
//                         console.log(response);
//                     }
//                 });
            });

            // drag event
            map.addListener('dragend', function () {
                var bounds = map.getBounds();
                var ne = bounds.getNorthEast();
                var sw = bounds.getSouthWest();
                $('#ne_lat').val(ne.lat());
                $('#ne_lng').val(ne.lng());
                $('#sw_lat').val(sw.lat());
                $('#sw_lng').val(sw.lng());
//                $.ajax({
//                    url: 'search-map',
//                    data: frontSearch.serialize(),
//                    processData: false,
//                    type: 'get',
//                    success: function (response) {
//                        $('#product-result').html(response);
//                        console.log(response);
//                    }
//                });
            });

        }

        // add marker
        function setMarkers(map) {

            for (var i = 0; i < locations.length; i++) {

                var lats = parseFloat(locations[i][1]);
                var lngs = parseFloat(locations[i][2]);
                var price = locations[i][0].toString();
                var nums = locations[i][3];
                var id = locations[i][4];
                var url = locations[i][5];

                var infowindow = new google.maps.InfoWindow({
                    position: {lat: lats, lng: lngs},
                    map: map,
                    content: '<a href="'+url+'" target="_blank"><div id="_item'+id+'" class="maps-mark-item">$' + price + '</div></a>',
                    zIndex: nums
                });
            }

        }


        $(document).ready(function () {
            initMap();

            $(".house-blk").hover(function () {
                var p_id = $(this).attr('id');
                $('#_item'+p_id).addClass('maps-point-hover');
            }, function () {
                var p_id = $(this).attr('id');
                $('#_item'+p_id).removeClass('maps-point-hover');
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
        });


    </script>
@stop