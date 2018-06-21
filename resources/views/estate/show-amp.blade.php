@extends('layout.amp')

@section('styles')
    <style amp-custom type="text/css">
        .facilities.col-3.list > li[data-value="1"].active {
            display: none;
        }
        .lg-toolbar {
            background: transparent;
            -webkit-transition: all .35s cubic-bezier(0,0,.25,1) 0s;
            transition: all .35s cubic-bezier(0,0,.25,1) 0s;
        }
        .lg-toolbar:hover {
            background-color: rgba(0,0,0,.45);
        }
        .lg-outer .lg-img-wrap {
            height: -webkit-calc(100% - 78px);
            height: calc(100% - 78px);
        }
        .single-related-amp .related-entry {
            display: block;
            min-height: unset;
            position: static;
        }
        .single-related-amp .related-entry .entry-price {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            margin: 0;
            background: rgba(0,0,0,.6);
            font-size: 14px;
            padding: 5px 10px 7px;
            z-index: 10;
        }
        .single-related-amp .related-entry .entry-title {
          font-size: 16.8px;
          margin-top: 7px;
        }
        .single-related-amp {
            padding: 0 30px;
            margin: 0 -2.5px;
        }
        .single-related-amp:last-child {
            margin-bottom: 3em;
        }
        .single-related-amp .related-entry .entry-price span {
            font-size: 21px;
            font-weight: 400;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <article id="content" class="single-product container">
        {!! Breadcrumbs::render('estate', $estate) !!}
        <div class="row">
            <div id="single-primary" class="col-xs-12">
                <h1><b class="product-id">{{ $estate->product_id }}</b><strong>{{ $estate->title }}</strong></h1>
                <amp-carousel class="gallery-top"
                    width="400"
                    height="300"
                    layout="responsive"
                    type="slides"
                    autoplay
                    controls
                    delay="5000">
                    @foreach($estate->resources as $index => $resource)
                        <amp-img src="{{ $resource->url }}"
                        width="400"
                        height="300"
                        layout="responsive"></amp-img>
                    @endforeach
                </amp-carousel>
                <div id="product-map" class="hidden-xs"></div>
                <div class="text-justify">{!! $estate->description !!}</div>
                <a href="#" data-toggle="modal" data-target="#modal-like-single" class="product-query visible-xs text-center text-white"><b>@lang('entity.estate.query')</b></a>
                <div class="product-interact row visible-xs">
                    <div class="col-sm-7 col-xs-12">
                        <div class="product-bookmark text-center">
                            <a href="#" class="btn-like btn-black like" data-id="{{ $estate->id }}"></a>
                            <b>@lang('entity.estate.like')</b>
                        </div>
                    </div>
                </div>
            </div>
            <div id="single-sidebar" class="col-xs-12">
                <div class="product-price {{ $current_locale }}">
                    <div class="col-xs-6">@lang('entity.estate.rent')<span class="big-number">{{ $estate->price }}</span>@lang('entity.estate.currency')</div>
                    <div class="col-xs-6 text-center">@lang('entity.estate.deposit')&nbsp;&nbsp;&nbsp;<span>{{ $estate->deposit }}</span></div>
                    <div class="clearfix"></div>
                </div>
                <p class="part-title">{{ \App\Term::getLocaleValue($first['name']) }}</p>
                <ul class="col-2 list text-center">
                @foreach ($first['values'] as $index => $value)
                    <li class="{{ in_array($index, $estate->{$first['key']}) ? 'active' : '' }}">{{ \App\Term::getLocaleValue($value) }}</li>
                @endforeach
                </ul>
                @foreach($above as $key => $value)
                    <div class="product-prop">
                        <div class="col-xs-4">{{ \App\Term::getLocaleValue($value['name']) }}</div>
                        <div class="col-xs-8 text-right">{{ $estate->{$key} ? $estate->{$key} : '--' }}</div>
                    </div>
                @endforeach
                <div class="product-prop">
                    <div class="col-xs-4">@lang('entity.estate.apartment')</div>
                    <div class="col-xs-8 text-right">{{ $estate->apartment ? link_to(action('ApartmentController@show', $estate->apartment->permalink), $estate->apartment->title) : '--' }}</div>
                </div>
                <div class="product-prop tag">
                    <div class="col-xs-2">@lang('entity.estate.category')</div>
                    <div class="col-xs-10 padding-10 text-right">
                        @foreach ($estate->categories as $index => $category)@if ($index > 0) / @endif<a href="{{ URL::action('CategoryController@show', $category->permalink) }}">{{ $category->title }}</a>@endforeach
                    </div>
                </div>
                @foreach($below as $key => $data)
                    <p class="part-title">{{ \App\Term::getLocaleValue($data['name']) }}</p>
                    <ul class="{{ $key }} col-3 list text-center">
                        @foreach($data['values'] as $index => $value)
                            <li data-value="{{ $index }}" class="{{ in_array($index, [212, 213]) ? 'invi' : '' }} {{ in_array($index, $estate->{$key}) ? 'active' : 'inactive' }}">{{ \App\Term::getLocaleValue($value) }}</li>
                        @endforeach
                    </ul>
                @endforeach
                <a href="#" data-toggle="modal" data-target="#modal-like-single" class="product-query text-center text-white"><b>@lang('entity.estate.query')</b></a>
                <div class="product-interact row">
                    <div class="col-sm-7 col-xs-12">
                        <div class="product-bookmark text-center">
                            <a href="#" class="btn-like btn-black like" data-id="{{ $estate->id }}"></a>
                            <b>@lang('entity.estate.like')</b>
                        </div>
                    </div>
                    <div class="col-sm-5 col-xs-12 hidden-xs">
                        <a href="#" class="product-print text-center">
                            <amp-img src="{{ asset('images/icon-print.svg') }}" alt="" layout="fill">
                            <b class="text-print">@lang('entity.estate.print')</b>
                        </a>
                    </div>
                </div>
                <div class="product-links row">
                    <div class="hidden-xs col-sm-5">
                        {{-- <a class="product-help-link" href="{{ url($pages_by_id[6]->permalink) }}"><amp-img width="13" height="13" src="{{ asset('images/about-home-4.png') }}" alt=""> @lang('entity.estate.property page')</a> --}}
                    </div>
                    <div class="col-xs-12 col-sm-7 text-right">
                        <a class="product-social" onclick="shareSocial('facebook')"><i class="icon icon-facebook"><span class="path1"></span><span class="path2"></i></a>
                        {{-- <a class="product-social" href="#"><i class="icon icon-instagram"></i></a> --}}
                        <a class="product-social" onclick="shareSocial('pinterest')"><i class="icon icon-pinterest"></i></a>
                        <a class="product-social" onclick="shareSocial('twitter')"><i class="icon icon-twitter"></i></a>
                        <a class="product-social" onclick="shareSocial('line', '{{ $estate->title }}')"><i class="icon icon-line"></i></a>
                        <a class="product-social" onclick="shareSocial('google')"><i class="icon icon-google"></i></a>
                        <a class="product-social" href="mailto:?"><i class="icon icon-email"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="single-others">
            @if ($siblings)
                <p class="part-title">@lang('entity.estate.same apartment')</p>
                <amp-carousel class="single-related-amp"
                    width="450"
                    height="300"
                    layout="responsive"
                    type="slides"
                    autoplay
                    controls
                    delay="3000">
                    @foreach($siblings as $index => $sibling)
                        <div class="item">
                            <a class="related-entry" href="{{ URL::action('RealEstateController@showAmp', $sibling->product_id) }}">
                                @if ($index < 3)
                                    <amp-img src="{{ $sibling->getPostThumbnail('estate_thumbnail') }}" class="img-full-width" alt="{{ $sibling->title }}" layout="fill">
                                @else
                                    <amp-img src="{{ $sibling->getPostThumbnail('estate_thumbnail') }}" class="lazyOwl img-full-width" alt="{{ $sibling->title }}" layout="fill">
                                @endif
                                <div class="entry-price text-white">
                                    <b><span>{{ $sibling->price }}</span> USD</b>
                                    <p class="entry-title single-line">{{ $sibling->title }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </amp-carousel>
            @endif
            @unless(empty($recents))
                <p class="part-title">@lang('entity.estate.recent estates')</p>
                <amp-carousel class="single-related-amp"
                    width="450"
                    height="300"
                    layout="responsive"
                    type="slides"
                    autoplay
                    controls
                    delay="3000">
                    @foreach($recents as $index => $recent)
                    <div class="item">
                        <a href="{{ URL::action('RealEstateController@showAmp', $recent->product_id) }}" class="related-entry">
                            @if ($index < 3)
                                <amp-img src="{{ $recent->getPostThumbnail('estate_thumbnail') }}" class="img-full-width" alt="{{ $recent->title }}" layout="fill"></amp-img>
                            @else
                                <amp-img src="{{ $recent->getPostThumbnail('estate_thumbnail') }}" class="lazyOwl img-full-width" alt="{{ $recent->title }}" layout="fill"></amp-img>
                            @endif
                            <div class="entry-price text-white">
                                <b><span>{{ $recent->price }}</span> USD</b>
                                <p class="entry-title single-line">{{ $recent->title }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </amp-carousel>
            @endunless
            <p class="part-title">@lang('entity.estate.relative estates')</p>
            <amp-carousel class="single-related-amp"
                    width="450"
                    height="300"
                    layout="responsive"
                    type="slides"
                    autoplay
                    controls
                    delay="3000">

                @foreach($relatives as $index => $relative)
                    <a href="{{ URL::action('RealEstateController@showAmp', $relative->product_id) }}" class="related-entry">
                        @if ($index < 3)
                            <amp-img src="{{ $relative->getPostThumbnail('estate_thumbnail') }}" class="img-full-width" alt="{{ $relative->title }}" layout="fill"></amp-img>
                        @else
                            <amp-img src="{{ $relative->getPostThumbnail('estate_thumbnail') }}" class="lazyOwl img-full-width" alt="{{ $relative->title }}" layout="fill"></amp-img>
                        @endif
                        <div class="entry-price text-white">
                            <b><span>{{ $relative->price }}</span> USD</b>
                            <p class="entry-title single-line">{{ $relative->title }}</p>
                        </div>
                    </a>
                @endforeach
                </div>
            </amp-carousel>
        </div>
    </article>
    <div class="modal" id="modal-like-single">
        <div class="modal-dialog modal-lg">
            <div class="popup-like modal-content single-estate">
                <button type="button" class="close visible-xs" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="text-uppercase text-center">Contact</h3>
                <a href="{{ action('RealEstateController@show', $estate->product_id) }}" class="media list-house-popup center-block">
                    <span class="pull-left">
                        <amp-img class="media-object" src="{{ $estate->post_thumbnail }}" width="150" height="150" alt="{{ $estate->title }}" layout="responsive"></amp-img>
                    </span>
                    <div class="media-body">
                        <h4 class="media-heading">ID {{ $estate->product_id }} {{ $estate->title }}</h4>
                        <p>{{ $estate->price }} $</p>
                    </div>
                </a>
                @include('partials.contact_form', ['prefix' => 'estate', 'estate_id' => $estate->id])
            </div>
        </div>
    </div>
@endsection

@section('edit')
    <li><a href="{{ action('Admin\RealEstateController@edit', $estate->id) }}">@lang('front.edit page')</a></li>
@endsection

@section('script-async')
    <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
    <script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-0.1.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
@endsection

@section('scripts')
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={{ env('APP_MAP_KEY') }}"></script>
    {{-- <script type="text/javascript" src="//maps.stamen.com/js/tile.stamen.js?v1.3.0"></script> --}}
    <script type="text/javascript">
        var $bookmark = $('.product-bookmark');
        (function initMap() {
            var map,
                latlng = new google.maps.LatLng({{ $estate->lat }}, {{ $estate->lng }}),
                //layer = "toner",
                mapOptions = {
                    zoom: 13,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false,
                    /*mapTypeId: layer,
                    mapTypeControlOptions: {
                        mapTypeIds: [layer]
                    }*/
                }
                geocoder = new google.maps.Geocoder;
                infowindow = new google.maps.InfoWindow;
            map = new google.maps.Map(document.getElementById("product-map"), mapOptions);
            //map.mapTypes.set(layer, new google.maps.StamenMapType(layer));

            var marker = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: latlng,
                radius: 400,

                //position: latlng,
                title: '{{ $estate->title }}'
            });

            /*geocoder.geocode({ 'location': latlng }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        infowindow.setContent(results[1].formatted_address);
                        infowindow.open(map, marker);
                    } else {
                        console.log('No results found');
                    }
                } else {
                    console.log('Geocoder failed due to: ' + status);
                }
            });*/
            //map.setCenterWithOffset(latlng, 0, -25);
        })();

        $('.product-print').click(function(event) {
            event.preventDefault();
            window.print();
        });

        $bookmark.click(function(event) {
            if ($('.product-bookmark > .btn-like').is(event.target)) return;
            var $btn_like = $(this).children('.btn-like'),
                estate_id = $btn_like.data('id');
            if (!$btn_like.hasClass('active') && $.inArray(estate_id, like_ids) === -1) {
                add_like(estate_id);
                $btn_like.next().text("@lang('entity.estate.liked')");
            }
            else if ($.inArray(estate_id, like_ids) >= 0) {
                remove_like(estate_id);
                $btn_like.next().text("@lang('entity.estate.like')");
            }
        });

        $(document).ready(function() {
            if ($bookmark.children('.btn-like').hasClass('active')) {
                $bookmark.children('b').text("@lang('entity.estate.liked')");
            }
        });
        // $(window).load(function() {
        //     var thumb_height = $('.entry-header > .img-full-width').first().css('height').replace('px', '');
        //     $('.owl-prev, .owl-next').css('top', parseInt(thumb_height / 2) + 'px');
        // });
        // $(window).resize(function(event) {
        //     setTimeout(function() {
        //         var thumb_height = $('.entry-header > .img-full-width').first().css('height').replace('px', '');
        //         $('.owl-prev, .owl-next').css('top', parseInt(thumb_height / 2) + 'px');
        //     }, 200);
        // });
    </script>
@endsection
