{{-- paginate --}}
@if (!empty($items) && count($items) > 0)
    {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($items))->map_render() !!}
    @foreach($items as $key => $item)
        <?php
        $page_map_data[] = [
            $item->price,
            $item->lat,
            $item->lng,
            $key,
            $item->product_id,
            url(action('RealEstateController@show', $item->product_id)),
        ];
        ?>
        <div class="col-md-12">
            <div class="house-blk" id="{{ $item->product_id }}">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="owl-carousel owl-theme house-carousel">
                            @foreach($item->resources as $index => $image)
                                <div class="item">
                                    <img src="{{ img_exists($image->estate_thumbnail) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="house-sub-title"><strong>{{ $item->price }}</strong>
                            USD　<span>（@lang('front.manage fee')）</span></div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="title-number">
                            <h2>
                                <a href="{{ URL::action('RealEstateController@show', $item->product_id) }}">{{ $item->product_id }}</a>
                            </h2>
                            <div class="btn-like like" data-id="{{ $item->id }}"><img
                                        src="{{ asset('images/new-layout/icon-heart.png') }}"></div>
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
    <input type="hidden" name="page_map_data" value="{{ (!empty($page_map_data)) ? json_encode($page_map_data) : '' }}">
    <input type="hidden" name="map_data_total" value="{{ (!empty($items->total())) ? $items->total() : '' }}">
    <input type="hidden" name="map_data_last_page" value="{{ $items->hasPages() ? 1 : 0 }}">
@endif
