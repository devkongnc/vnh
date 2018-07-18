<!-- show grid -->
<div class="row list-product">
    @foreach($items as $item)
    <div class="col-md-6">
        <div class="house-blk highest-box">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="owl-carousel owl-theme house-carousel">
                        @foreach($item->resources as $index => $image)
                            <div class="item">
                                <img src="{{ img_exists($image->estate_thumbnail) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <div class="house-sub-title"><strong>{{ $item->price }} {{ (!empty($item->price_max)) ?' ~ '.$item->price_max:'' }}</strong> USD/㎡<span>（@lang('front.manage fee')）</span></div>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->description), 200) }}</p>
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

                    <ul class="house-feature">
                        @foreach($equipments as $key => $data)
                            @foreach($data['values'] as $index => $value)
                                @if($key === 'facilities' || $key === 'surroundings')
                                <li data-key="{{$index}}" class="{{ in_array($index, (array) $item->{$key}) ? "" : 'inactive' }} ">
                                    {{ \App\Term::getLocaleValue($value) }}
                                </li>
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
