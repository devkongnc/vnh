@extends('layout.base')

@section('content')
    <article id="content" class="single-apartment container">
        {!! Breadcrumbs::render('apartment', $apartment) !!}
        <section class="tab-hightrise">
            <div>
              <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#introduction" aria-controls="introduction" role="tab" data-toggle="tab">Introduction</a></li>
                    <li ><a href="#feature" aria-controls="feature" role="tab" data-toggle="tab">Feature</a></li>
                    <li ><a href="#location" aria-controls="location" role="tab" data-toggle="tab">Location</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane cont-tab active" id="introduction">
                        <div class="left-tab">
                            <div>
                                <div class="right-tab">
                                    <div class="list-img owl-tab">
                                        @foreach($apartment->resources as $image)
                                            <div><img class="lazyOwl" data-src="{{ $image->medium }}"></div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="title">{!! $apartment->title  !!}</div>
                                {!! $apartment->description !!}
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane tab-feature" id="feature">
                        <div class="tbl-feature">
                            <div class="body-tbl">
                                <div class="row-feature feature-head">
                                    <div>@lang('admin.apartment.basic')</div>
                                </div>
                                @foreach($terms->filter(function($item) { return $item['group'] === 'basic'; }) as $key => $values)
                                    <div class="row-feature {{ $key }}">
                                        <div>{{ getLocaleValue($values['name']) }}</div>
                                        <div>{{ $apartment->{$key} }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tbl-feature">
                            <div class="body-tbl">
                                <div class="row-feature feature-head">
                                    <div>@lang('admin.apartment.equipment')</div>
                                </div>
                                @foreach($terms->filter(function($item) { return $item['group'] === 'equipment'; }) as $key => $values)
                                    <div class="row-feature">
                                        <div>{{ \App\Term::getLocaleValue($values['name']) }}</div>
                                        <div>{{ $apartment->{$key} }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tbl-feature">
                            <div class="body-tbl">
                                <div class="row-feature feature-head">
                                    <div>@lang('admin.apartment.indoor_facilities')</div>
                                </div>
                                @foreach($terms->filter(function($item) { return $item['group'] === 'indoor_facilities'; }) as $key => $values)
                                    <div class="row-feature">
                                        <div>{{ \App\Term::getLocaleValue($values['name']) }}</div>
                                        <div>{{ $apartment->{$key} }}</div>
                                    </div>
                                @endforeach
                                <div class="row-feature feature-head">
                                    <div>@lang('admin.apartment.children_facilities')</div>
                                </div>
                                @foreach($terms->filter(function($item) { return $item['group'] === 'children_facilities'; }) as $key => $values)
                                    <div class="row-feature">
                                        <div>{{ \App\Term::getLocaleValue($values['name']) }}</div>
                                        <div>{{ $apartment->{$key} }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="location">
                        <div class="tab-map">
                            <!-- <img src="images/tab-location.png"> -->
                            <div id="map-canvas"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="wrap-apartment">
            <div class="top-apartment">
                <div class="title-top">@lang('entity.apartment.estate list')</div>
                <div class="filter-right">
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
                    <a class="btn" href="{{ action('ApartmentController@index') }}" role="button">@lang('entity.apartment.apartment list')</a>
                </div>
                <div class="clearfix"></div>
            </div>
            @include('partials.three-grid', ['items' => $estates])
        </section>
        {{-- <div class="pagination-wrapper">
            with(new App\VietnamHouse\Pagination\PaginationPresenter($estates))->render()
        </div> --}}
    </article>
@endsection

@section('edit')
    <li><a href="{{ action('Admin\ApartmentController@edit', $apartment->id) }}">@lang('front.edit page')</a></li>
@endsection

@section('scripts')
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={{ env('APP_MAP_KEY') }}&libraries=places&callback=initMap" async defer ></script>
    <script type="text/javascript">
        var map, marker, geocoder, infowindow;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 17,
                center: { lat: {{ $apartment->lat }}, lng: {{ $apartment->lng }} },
                scrollwheel: false,
            });
            var image = '{{ asset('images/localtion-map.png') }}';
            marker = new google.maps.Marker({
                position: {lat: {{ $apartment->lat }}, lng: {{ $apartment->lng }} },
                map: map,
                icon: image
            });
            geocoder = new google.maps.Geocoder;
            infowindow = new google.maps.InfoWindow;
        }
        $('#modal-position').on('shown.bs.modal', function(event) {
            var map,
                button = $(event.relatedTarget),
                position = new google.maps.LatLng(parseFloat(button.data('lat')), parseFloat(button.data('lng')));
             //layer = "toner",
                mapOptions = {
                    zoom: 13,
                    center: position,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false,
                    /*mapTypeId: layer,
                     mapTypeControlOptions: {
                     mapTypeIds: [layer]
                     }*/
                }
            geocoder = new google.maps.Geocoder;
            infowindow = new google.maps.InfoWindow;
            map = new google.maps.Map(document.getElementById("estate-map"), mapOptions);

            var marker = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: position,
                radius: 200,
                //position: latlng,
                title: ''
            });
        });
        $('.tab-hightrise .nav-tabs li a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            initMap();
        });
        $("#order-type").change(function(){
            window.location.replace('{{ URL::current() }}?order=' + $(this).val());
        });
    </script>
@overwrite
