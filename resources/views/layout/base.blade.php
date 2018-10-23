<!DOCTYPE html>
<html lang="{{ $current_locale }}">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    @if (Route::is('home'))
        @if (App::isLocale('ja'))
            <title>ベトナムハウス - office｜ホーチミンのオフィス専門賃貸情報</title>
            <meta name="description" content="ベトナム・ホーチミン市のオフィス(事務所)専門の不動産賃貸サイトです。オフィスのグレードや大小に関わらずほぼ全ての賃貸情報を取り扱っております。仲介手数料無料で日本人専任スタッフがしっかりサポートいたします。オフィスもベトナムハウス！">
            <meta name="keywords" content="オフィス,事務所,office,ホーチミン,賃貸,ベトナム,不動産,レンタオフィス,サービスオフィス,進出,会社登記�">

            <meta property="og:title" content="ベトナムハウス - office｜ホーチミンのオフィス専門賃貸情報" />
            <meta property="og:type" content="website" />
            <meta property="og:url" content="{{ asset('') }}" />
            <meta property="og:description" content="ベトナム・ホーチミン市のオフィス(事務所)専門の不動産賃貸サイトです。オフィスのグレードや大小に関わらずほぼ全ての賃貸情報を取り扱っております。仲介手数料無料で日本人専任スタッフがしっかりサポートいたします。オフィスもベトナムハウス！" />
            <meta property="og:image" content="{{ asset('/images/new-layout/top-img.jpg') }}" />
        @elseif(App::isLocale('vi'))
            <title>VIETNAMHOUSE - office｜Thông tin văn phòng cho thuê tại TP. Hồ Chí Minh</title>
            <meta name="description" content="Công ty chúng tôi cung cấp dịch vụ cho thuê văn phòng tại Tp Hồ Chí Minh. Chúng tôi có thể hỗ trợ bạn tìm văn phòng tuỳ theo diện tích, bậc hạng văn phòng theo nhu cầu của bạn. Chúng tôi cung cấp dịch vụ cho thuê miễn phí và dịch vụ hỗ trợ tốt nhất.">
            <meta name="keywords" content="Văn phòng,trụ sở,office,Hồ Chí Minh,cho thuê,thuê,Việt Nam,Bất Động Sản,Văn phòng ảo,văn phòng chia sẻ,di dời trụ sở,đăng ký kinh doanh">

            <meta property="og:title" content="VIETNAMHOUSE - office｜Thông tin văn phòng cho thuê tại TP. Hồ Chí Minh" />
            <meta property="og:type" content="website" />
            <meta property="og:url" content="{{ asset('/vi') }}" />
            <meta property="og:description" content="Công ty chúng tôi cung cấp dịch vụ cho thuê văn phòng tại Tp Hồ Chí Minh. Chúng tôi có thể hỗ trợ bạn tìm văn phòng tuỳ theo diện tích, bậc hạng văn phòng theo nhu cầu của bạn. Chúng tôi cung cấp dịch vụ cho thuê miễn phí và dịch vụ hỗ trợ tốt nhất." />
            <meta property="og:image" content="{{ asset('/images/new-layout/top-img.jpg') }}" />
        @else
            <title>VIETNAMHOUSE - office｜Office space for rent in Ho Chi Minh City (HCMC)</title>
            <meta name="description" content="This is our special site for commercial lease in Ho Chi Minh City. If you are looking for an office, big or small, top grade or co-working space, we are always ready to offer the most suitable options. We provide free commercial lease service with the best support.">
            <meta name="keywords" content="office,hcm,for,rent,ho chi minh,vietnam,real estate, rental office, service office, co-working, virtual office, start up, office launch, company registration">

            <meta property="og:title" content="VIETNAMHOUSE - office｜Office space for rent in Ho Chi Minh City (HCMC)" />
            <meta property="og:type" content="website" />
            <meta property="og:url" content="{{ asset('') }}" />
            <meta property="og:description" content="This is our special site for commercial lease in Ho Chi Minh City. If you are looking for an office, big or small, top grade or co-working space, we are always ready to offer the most suitable options. We provide free commercial lease service with the best support." />
            <meta property="og:image" content="{{ asset('/images/new-layout/top-img.jpg') }}" />
        @endif
    @else
        {!! SEO::generate(true) !!}
    @endif
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Language" content="{{ $current_locale }}"/>
    <meta name="viewport" content="{{ Cookie::get('vnh_desktop', 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1') }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="google-site-verification" content="-a-KdRRZjx9pSqDJNV1Yk5ayQhu3U6_meiDAcewPpqo"/>
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>

<!-- Favicon
    ============================================== -->
    <link rel="shortcut icon" href="{{ asset('images/new-layout/favicon.png') }}">
    <!-- Mobile Specific
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSS Files
    ================================================== -->

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-plugin.js') }}"></script>

    <style type="text/css">
        @import url('https://fonts.googleapis.com/earlyaccess/notosansjapanese.css');
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/css-lib.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ elixir('css/css-custom.min.css') }}">

    <style type="text/css">
        @if (App::isLocale('ja'))
            body {
                font-family: "Noto Sans Japanese", Arial, "sans-serif";
            }
        @endif

        div.phpdebugbar pre {
            width: 1000px;
        }
    </style>

    @yield('styles')


    <style type="text/css">
        .slider-container.theme-green{
            width: 300px !important;
        }
    </style>
</head>

<body class="{{ is_null(Route::current()) ? '' : ((strpos(Route::current()->getUri(), 'search-map') !== FALSE)?' change-body-padding ':'') }}">

<div id="top"></div>

@include('layout.header')

@yield('content')

@if(!is_null(Route::current()) && strpos(Route::current()->getUri(), 'search-map') === FALSE)
    @include('layout.footer')
@elseif (is_null(Route::current()))
    @include('layout.footer')
@endif

<!-- <a id="back_to_top" href="#">
    <span class="fa-stack">
        <img src="{{ asset('images/new-layout/totop.png') }}">
    </span>
</a> -->

<div class="modal sp-modal-contract" id="modal-like">
    <div class="modal-dialog modal-lg">
        <div class="popup-like modal-content">
            <div class="top-popup">
                <div>
                    <p>@lang('front.popup.contact.description')</p>
                    <p class="clear-like-wraper"><span class="clear-like icon-close-light"><span class="path1"></span><span class="path2"></span></span> @lang('front.popup.contact.like remove')
                    </p>
                </div>
                <div class="img-top">
                    <div class="img-responsive img-btn-like" alt="like" ></div>
                </div>
            </div>
            <div class="list-house-popup"></div>
            @include('partials.contact_form', ['prefix' => 'like'])
            <div class="close-like" data-dismiss="modal" aria-label="Close">
                <span class="close-btn">
                    <img src="{{ asset('images/new-layout/close.png') }}">
                </span>
            </div>
        </div>
    </div>
</div>


<div class="quest-popup">
    <div class="quest-popup-wrap">
        <span class="quest-popup-close"><i class="fa fa-times"></i></span>
        <div class="quest-popup-top">
            <h3>30人規模オフィスの面積を算出しよう！</h3>
        </div>
        <div class="quest-popup-cal">
            <form>
                <select class="quest-input-size">
                    <option value="0">一人当たり</option>
                    <option value="3">3m&sup2;</option>
                    <option value="4">4m&sup2;</option>
                    <option value="5">5m&sup2;</option>
                    <option value="6">6m&sup2;</option>
                    <option value="7">7m&sup2;</option>
                    <option value="8">8m&sup2;</option>
                    <option value="9">9m&sup2;</option>
                    <option value="10">10m&sup2;</option>
                </select>
                <span><strong>X</strong></span>
                <input type="number" class="quest-input-number" placeholder="人数">
                <span><strong>=</strong></span>
                <input type="text" class="quest-input-result" disabled>
            </form>
        </div>
        <div class="quest-popup-img">
            <img src="{{ asset('images/popup/popup-im1.png') }}">
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
    .quest-popup{
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(6, 6, 6, 0.7);
        height: 100%;
        z-index: 999;
        display: none;
    }
    .quest-popup-wrap{
        width: 720px;
        background: #fff;
        margin: 0 auto;
        text-align: center;
        padding: 25px 70px;
        margin-top: 5%;
        position: relative;
    }
    .quest-popup-close{
        position: absolute;
        top: 0;
        right: 0;
        width: 40px;
        height: 40px;
        text-align: center;
        line-height: 40px;
        font-size: 22px;
        color: #b5b5b5;
    }
    .quest-popup-close:hover{
        color: #000;
        cursor: pointer;
    }
    .quest-popup-top, .quest-popup-cal, .quest-popup-img, .quest-popup-img img{
        width: 100%;
        margin: 5px 0;
    }
    .quest-popup-top h3{
        border: 2px solid;
        padding: 15px;
    }
    .quest-popup-cal{
        padding: 10px 0;
    }
    .quest-popup-cal select{
        min-width: 120px;
        padding: 5px;
    }
    .quest-input-number{
        width: 120px;
        padding: 5px;
        border: 1px solid #ccc;
    }
    .quest-input-result{
        padding: 5px;
        border: 1px solid #ccc;
        background: #fff;
    }
</style>

<script type="text/javascript">
    $('.quest-input-number').bind('keyup blur change click', function () {
        var result = $(this).val()*$('.quest-input-size').val();
        if (result != 0 || result != ''){
            $('.quest-input-result').val('');
            $('.quest-input-result').val( result+'m²' );
        }else{
            $('.quest-input-result').val('');
        }
    });
    $('.quest-input-size').change(function () {
            var str = 0;
            $('.quest-input-size option:selected').each(function() {
                str = $( this ).val();
                // console.log(str);
            });
            var result = str*$('.quest-input-number').val();
            if (result != 0 || result != ''){
                $('.quest-input-result').val('');
                $('.quest-input-result').val( result+'m²' );
            }else{
                $('.quest-input-result').val('');
            }
        }).change();

    $('.quest-btn').click(function () {
        $('.quest-popup').show();
    });
    $('.quest-popup-close').click(function () {
        $('.quest-popup').hide();
    });
</script>

<script type="text/javascript">
    var estate_ajax = '{{ action('RealEstateController@index') }}';
    var txt_like_default_text = '{{ trans('front.like_default_text') }}';
    var txt_like_add = '{{ trans('front.like_add_text') }}';
    var txt_like_current = '{{ trans('front.like_current_text') }}';
    var txt_bt_like_selected = '{{ trans('entity.estate.liked') }}';
    var txt_bt_like_not_select = '{{ trans('entity.estate.like') }}';
    var txt_bt_area_default = '{{ trans('search.multiple-choice') }}';
    var txt_bt_area_selected = '{{ trans('search.multiple-choice-selected') }}';

    function estate_permalink(product_id) {
        return '{{ action('RealEstateController@show', 'product_id') }}'.replace('product_id', product_id);
    }
</script>
<script type="text/javascript" src="{{ elixir('js/js-custom.js') }}"></script>


@if(env('APP_ENV') == 'local' || env('APP_ENV') == 'develop')
    {{--key for local dev //vnh.local--}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy_KoPR6v-mzse7nWjricn1TTmnw9OP44"></script>
@else
    {{--key for server real //office.vietnamhouse.jp--}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('APP_MAP_KEY') }}"></script>
@endif


@yield('scripts')

<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5GGNW3');
</script>
</body>

</html>
