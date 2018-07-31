{{-- paginate --}}
@if (!empty($items) && count($items) > 0)
    {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($items))->map_render() !!}
    @foreach($items as $key => $item)
        <?php
        $page_map_data[] = [
            $item->price.(!empty($item->price_max) ?'~'.$item->price_max:''),
            $item->lat,
            $item->lng,
            $key,
            $item->product_id,
            url(action('RealEstateController@show', $item->product_id)),
            $item->title,
            img_exists($item->resource->path),
        ];
        ?>
        <div class="col-md-12">
            <div class="house-blk" id="{{ $item->product_id }}" data-link="{{ URL::action('RealEstateController@show', $item->product_id) }}">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="owl-carousel owl-theme house-carousel">
                            @foreach($item->resources as $index => $image)
                                <div class="item">
                                    <img src="{{ img_exists($image->estate_thumbnail) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="house-sub-title"><strong>{{ $item->price }} {{ (!empty($item->price_max)) ?' ~ '.$item->price_max:'' }}</strong> USD/㎡</strong>
                            <span>（@lang('front.manage fee')）</span></div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="title-number">
                            <h2>
                                <a href="{{ URL::action('RealEstateController@show', $item->product_id) }}">{{ $item->product_id }}</a>
                            </h2>
                            <div class="btn-like like" data-id="{{ $item->product_id }}"><div class="img-btn-like none_selected" data-id="{{ $item->product_id }}"
                                ></div></div>
                        </div>
                        <a href="{{ URL::action('RealEstateController@show', $item->product_id) }}">
                            <h3>{!! $item->title  !!}&nbsp;</h3>
                        </a>
                        <table class="house-info">
                            <tr>
                                <td class="tdl">@lang('front.area')</td>
                                <td class="tdr">{{ $item->area }}</td>
                            </tr>
                            <tr>
                                <td class="tdl">@lang('front.address')</td>
                                <td class="tdr">{{ $item->address }}</td>
                            </tr>

                            <tr>
                                <td class="tdl">@lang('entity.estate.deposit')</td>
                                <td class="tdr">{{ (!empty($item->contract_limit)
                                                        ? $item->contract_limit.trans('entity.estate.contract_limit_year_unit')
                                                            .((LaravelLocalization::getCurrentLocale()==='en' && (int)$item->contract_limit > 1)?'s':'') : '') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="tdl">@lang('front.size')</td>
                                <td class="tdr">{{ (!empty($item->size)? number_format((int)$item->size).' m²' : '')}}
                                </td>
                            </tr>
                            <tr>
                                <td class="tdl">@lang('front.floor')</td>
                                <td class="tdr">{{ (!empty($item->floor)
                                                        ? $item->floor.trans('entity.estate.floor_unit') : '') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="tdl">@lang('front.anniversary_age')</td>
                                <td class="tdr">{{ (($item->anniversary != "0000-00-00" && !empty($item->anniversary))
                                ?(string) date(''.trans('front.anniversary_age_date_format'), strtotime($item->anniversary)) : '') }}
                                </td>
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
