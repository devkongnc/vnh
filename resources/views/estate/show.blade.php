@extends('layout.base')

@section('content')
    <div class="content-l detail-estate-main-content">
        <div class="title-details">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <label>{{ $estate->product_id }}</label>
                    <span class="title-txt">{{ $estate->title }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 col-sm-7">
                <div class="center">
                    <div class="hide-mobile">
                        <div class="container-gallery">
                            @foreach($estate->resources as $index => $resource)
                                <img src="{{ img_exists($resource->path) }}" alt="{{ $estate->title }}"/>
                            @endforeach
                        </div>
                    </div>

                    <div class="show-mobile">
                        <div class="owl-carousel owl-theme house-carousel">
                            @foreach($estate->resources as $index => $image)
                                <div class="item">
                                    <img src="{{ img_exists($image->estate_thumbnail) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="gmail-details">
                    <iframe src="https://maps.google.com/maps?q={{ $estate->lat }},{{ $estate->lng }}&z=15&amp;output=embed"
                            frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>


            <div class="col-md-5 col-sm-5">
                <div class="col-md-12 right group-date-like">
                    <span class="title-info-sm">@lang('front.last updated')　{{ $estate->custom_updated_at }}</span>
                    <div class="like-btn btn-like like img-btn-like none_selected" data-id="{{ $estate->product_id }}" ></div>
                </div>
                <div class="grey-bg-info">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-8">
                            @lang('entity.estate.rent') <strong
                                    class="big-price">{{ $estate->price }} {{  (!empty($estate->price_max)) ?' ~ '.$estate->price_max:'' }}</strong>
                            USD / ㎡
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 right" style="font-weight: 700">
                            @lang('entity.estate.deposit') {{ $estate->deposit }}
                        </div>
                    </div>
                    <div class="row estate_inclusive_content">
                        <div class="col-md-12">
                            <span class="estate-detail-vat-title">
                            @foreach ($first['values'] as $index => $value)
                                @if(in_array($index, $estate->{$first['key']}))
                                    <span class="estate-detail-vat">
                                        {{ \App\Term::getLocaleValue($value).trans('entity.estate.inclusive_included_unit') }}
                                    </span>
                                @else
                                    <span class="estate-detail-vat">
                                        {{ \App\Term::getLocaleValue($value).trans('entity.estate.inclusive_not_included_unit') }}
                                    </span>
                                @endif
                            @endforeach
                            </span>
                        </div>
                    </div>

                </div>
                <div class="row house-detail-row">
                    <div class="col-md-6 col-sm-6 col-xs-6 nopadding-rl">
                        <table class="house-info">
                            @foreach($above as $key => $value)
                                <?php if ($key !== 'city' && $key !== 'type'){ ?>
                                    <tr>
                                        <td>
                                            <?php
                                            switch ($key) {
                                                case 'contract_limit' :
                                                    $str = Form::label("{$key}",
                                                        (!empty($estate->{$key})
                                                            ? $estate->{$key}.trans('entity.estate.contract_limit_year_unit')
                                                            .((LaravelLocalization::getCurrentLocale()==='en' && (int)$estate->{$key} > 1)?'s':'') : ''),
                                                        ['readonly'=>'readonly']);
                                                    break;
                                                case 'size' :
                                                    $str = Form::label("{$key}",
                                                        (!empty($estate->{$key})
                                                            ? number_format((int)$estate->{$key}).' m²' : ''),
                                                        ['readonly'=>'readonly']);
                                                    break;
                                                case 'floor' :
                                                    $str = Form::label("{$key}",
                                                        (!empty($estate->{$key})
                                                            ? $estate->{$key}.trans('entity.estate.floor_unit') : ''),
                                                        ['readonly'=>'readonly']);
                                                    break;
                                                case 'anniversary' :
                                                    $str = Form::label("{$key}",
                                                        (($estate->{$key} != "0000-00-00" && !empty($estate->{$key}))
                                                            ?(string) date(''.trans('entity.estate.anniversary_date_format'), strtotime($estate->{$key})) : ''),
                                                        ['readonly'=>'readonly']);
                                                    break;
                                                case 'commiss' :
                                                    $str = $estate->{$key} ? $estate->{$key} : '<span class="commiss_free">'.trans('entity.estate.free_unit').'</span>';
                                                    break;
                                                default:
                                                    $str = Form::label("{$key}",(!empty($estate->{$key})? $estate->{$key} : ''),
                                                        ['readonly'=>'readonly']);
                                                    break;
                                            }
                                            ?>
                                            <div class="tdl">{{ \App\Term::getLocaleValue($value['name']) }}</div>
                                            <div class="tdr">{!! $str !!}</div>
                                        </td>
                                    </tr>
                            <?php } ?>
                        @endforeach
                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 nopadding-r">
                    <ul class="house-feature2">
                        @foreach($below as $key => $data)
                            @foreach($data['values'] as $index => $value)
                                <li data-key="{{$index}}" class="{{ in_array($index, (array) $estate->{$key}) ? "" : 'inactive' }} ">
                                    {{ \App\Term::getLocaleValue($value) }}
                                </li>
                            @endforeach
                        @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row group-action-estate">
                    <div class="col-md-12">
                        <a href="{{ URL::action('HomeController@about', ['contact', 'product_id' => $estate->product_id]) }}" class="product-query big-contact-btn">@lang('entity.estate.query')</a>
                        <a href="#" class="btn-like big-favorite-btn" data-id="{{ $estate->product_id }}"><div
                                    class="img-btn-like none_selected" data-id="{{ $estate->product_id }}" ></div>
                            <span>@lang('entity.estate.like')</span>
                        </a>
                        <a href="#" class="product-print big-print-btn"><img
                                    src="{{ asset('images/new-layout/icon-print.png') }}"> @lang('entity.estate.print')
                        </a>
                    </div>
                </div>
                <div class="center">
                    <ul class="social-list">
                        <li><a class="fb-s product-social" onclick="shareSocial('facebook')"></a></li>
                        <li><a class="tw-s product-social" onclick="shareSocial('twitter')"></a></li>
                        <li><a class="pt-s product-social" onclick="shareSocial('pinterest')"></a></li>
                        <li><a class="li-s product-social" onclick="shareSocial('line', '{{ $estate->title }}')"></a></li>
                        {{--<li><a class="gm-s product-social" onclick="shareSocial('google')"></a></li>--}}
                        <li><a class="em-s product-social" href="mailto:hello@vietnamhouse.jp"></a></li>
                    </ul>
                </div>
                <p class="house-details-txt">
                    <?php echo strip_tags($estate->description); ?>
                </p>

            </div>
        </div>

        <div class="black-bg">
            <div class="related-house">
                <h3>@lang('entity.estate.relative estates')</h3>
                <div class="owl-carousel owl-theme related-house-carousel">
                    @foreach($relatives as $index => $relative)
                        <div class="item">
                            <a class="rh-blk"
                               href="{{ URL::action('RealEstateController@show', $relative->product_id) }}">
                                <img src="{{ img_exists($relative->post_thumbnail) }}"/>
                                <span class="rh-info"><strong>{{ $relative->price }} {{  (!empty($relative->price_max)) ?' ~ '.$relative->price_max:'' }}</strong> USD/㎡</span>
                                <p style="min-height:38px">{{ str_limit($relative->title, 40) }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @unless(empty($recents))
                <div class="related-house">
                    <h3>@lang('entity.estate.recent estates')</h3>
                    <div class="owl-carousel owl-theme related-house-carousel">
                        @foreach($recents as $index => $recent)
                            <div class="item">
                                <a class="rh-blk"
                                   href="{{ URL::action('RealEstateController@show', $recent->product_id) }}">
                                    <img src="{{ img_exists($recent->post_thumbnail) }}"/>
                                    <span class="rh-info"><strong>{{ $recent->price }} {{  (!empty($recent->price_max)) ?' ~ '.$recent->price_max:'' }}</strong> USD/㎡</span>
                                    <p style="min-height:38px">{{ str_limit($recent->title, 40) }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endunless

        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.product-print').click(function (event) {
                event.preventDefault();
                window.print();
            });

//            $('.house-info input[type="text"]').each(function () {
//                var input_width = $(this).width();
//                var text_length = $(this).textWidth();
//                if (text_length > input_width) {
//                    var KeyFrame = {init: function(){
//                                if(!KeyFrame.check) {
//                                    var css = $('<style>@keyframes marquee{' +
//                                        '0%{text-indent:50%}' +
//                                        '10%{text-indent:50%}' +
//                                        '60%{text-indent:-'+(text_length-input_width)+'px}' +
//                                        '100%{text-indent:50%}}</style>')
//                                        .appendTo('head');
//                                    KeyFrame.check = true;
//                                }
//                            }
//                        };
//                    KeyFrame.init();
//
//                    $(this).addClass('marquee');
//                }
//            });
        });

    </script>
@endsection

@section('styles')
    <style type="text/css" media="print">
        @media print {
            * {
                -webkit-print-color-adjust: exact; !important;
                color-adjust: exact !important;
            }
        }
        @page {
            size:A4 landscape;
            margin: 10px;
            -webkit-print-color-adjust: exact;
        }
    </style>
    <style>
        .social-list li a:hover{
            cursor: pointer;
        }
    </style>
@endsection
