<div class="row row-map">
    <!-- show grid -->
    <div class="house-list-scroll">
        @foreach($items as $item)
            <div class="col-md-12">
                <div class="house-blk" id="{{ $item->product_id }}">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="owl-carousel owl-theme house-carousel">
                                @foreach($item->resources as $index => $image)
                                    <div class="item">
                                        <img src="{{ asset($image->medium) }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                            <div class="house-sub-title"><strong>{{ $item->price }}</strong> USD　<span>（@lang('front.manage fee')）</span></div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="title-number">
                                <h2> <a href="{{ URL::action('RealEstateController@show', $item->product_id) }}">{{ $item->product_id }}</a></h2>
                                <div class="btn-like like" data-id="{{ $item->id }}"><img src="{{ asset('images/new-layout/icon-heart.png') }}" ></div>
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
    </div>
</div>

