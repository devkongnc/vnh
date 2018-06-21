<?php $location = array(); ?>
<?php foreach ($items as $key => $value) { ?>
    <?php $location[] = [$value->price,$value->lat,$value->lng,$key]; ?>
<?php } ?>

<div class="row row-map">
    <!-- show grid -->
    <div class="house-list-scroll">
        @foreach($items as $item)
        <div class="house-list hidden-tablet">
            <div class="house-blk highest-box">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="owl-carousel owl-theme house-carousel">
                            @foreach($item->resources as $index => $image)
                                <div class="item">
                                    <img src="{{ $image->medium }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="house-sub-title"><strong>{{ $item->price }}</strong> USD　<span>（@lang('front.manage fee')）</span></div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="title-number">
                            <h2>{{ $item->product_id }}</h2>
                            <div class="like"><img src="{{ asset('images/new-layout/icon-heart.png') }}" ></div>
                        </div>
                        <a href="{{ URL::action('RealEstateController@show', $item->product_id) }}">
                        <h3>{{ str_limit($item->title, 30) }}</h3>
                        </a>
                        <table class="house-info">
                            <tr>
                                <td class="tdl">@lang('front.area')</td>
                                <td class="tdr">{{ $item->area }}</td>
                            </tr>
                            <tr>
                                <td class="tdl">@lang('front.location')</td>
                                <td class="tdr">{{ $item->city }}</td>
                            </tr>
                            <tr>
                                <td class="tdl">@lang('entity.estate.deposit')</td>
                                <td class="tdr">{{ $item->deposit }}</td>
                            </tr>
                            <tr>
                                <td class="tdl">@lang('front.size')</td>
                                <td class="tdr">{{ $item->size }}</td>
                            </tr>
                            <tr>
                                <td class="tdl">@lang('front.last updated')</td>
                                <td class="tdr">{{ $item->updated_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{-- show maps --}}
    <div class="house-list-map">
        <div id="map-result"></div>
        <script>
            var locations = {!! json_encode($location) !!};

            // show maps
            function initMap() {
                var x = 0;
                var y = 0;
                for (var i = 0; i < locations.length; i++) {
                    // khai báo giá trị
                    var lats = parseFloat(locations[i][1]);
                    var lngs = parseFloat(locations[i][2]);

                    x += lats/(locations.length);
                    y += lngs/(locations.length);
                }
                // console.log(x+'-'+y);

                var myLatLng = {lat: x, lng: y};
                var map = new google.maps.Map(document.getElementById('map-result'), {
                    center: myLatLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                // call marker
                setMarkers(map);

                var frontSearch = $("form[id='front-search']");

                // zoom event
                // map.addListener('zoom_changed', function() {
                //     var bounds =  map.getBounds();
                //     var ne = bounds.getNorthEast();
                //     var sw = bounds.getSouthWest();
                //     $('#ne_lat').val(ne.lat());
                //     $('#ne_lng').val(ne.lng());
                //     $('#sw_lat').val(sw.lat());
                //     $('#sw_lng').val(sw.lng());
                //     $.ajax({
                //         url: 'search-map',
                //         data: frontSearch.serialize(),
                //         processData: false,
                //         type: 'get',
                //         success: function (response) {
                //             $('#product-result').html(response);
                //             console.log(response);
                //         }
                //     });
                // });

                // drag event
                map.addListener('dragend', function() {
                    var bounds =  map.getBounds();
                    var ne = bounds.getNorthEast();
                    var sw = bounds.getSouthWest();
                    $('#ne_lat').val(ne.lat());
                    $('#ne_lng').val(ne.lng());
                    $('#sw_lat').val(sw.lat());
                    $('#sw_lng').val(sw.lng());
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

            }

            // add marker
            function setMarkers(map) {
                var getBound = new google.maps.LatLngBounds();
                for (var i = 0; i < locations.length; i++) {
                    // khai báo giá trị
                    var lats    = parseFloat(locations[i][1]);
                    var lngs    = parseFloat(locations[i][2]);
                    var price   = locations[i][0].toString();
                    var nums    = locations[i][3];

                    // gán marker trên maps
                    // var marker = new google.maps.Marker({
                    //     position: {lat: lats, lng: lngs},
                    //     map: map,
                    //     zIndex: nums
                    // });

                    // add infowindow box
                    var infowindow = new google.maps.InfoWindow({
                        position: {lat: lats, lng: lngs},
                        map: map,
                        content: '$'+price,
                        zIndex: nums
                    });
                    infowindow.open(map);

                    getBound.extend({lat: lats, lng: lngs});
                }
                map.fitBounds(getBound);
            }
        </script>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        initMap();
        $('.house-carousel').owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            navText : ["",""],
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
    });
</script>
