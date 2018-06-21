<div class="popup-thankyou">
    <div class="wrap-thankyou">
        <div class="box-thankyou">
            <div class="top-star"><span class="icon-star-orange"></span></div>
            @if((App::isLocale('ja')))
                <div class="title-thankyou" style="font-size: 50px;">@lang('front.popup.thankyou.title')</div>
            @else
                <div class="title-thankyou">@lang('front.popup.thankyou.title')</div>
            @endif
            <div class="sub-thankyou">@lang('front.popup.thankyou.subtitle', ['name' => request('name')])</div>
            <div class="desc-thankyou">
                @lang('front.popup.thankyou.description')
            </div>
            <div class="btn-bottom"><a class="btn-close" href="#">@lang('front.popup.close')</a></div>
        </div>
        <div class="close-thankyou"><span class="icon-close-light"><span class="path1"></span><span class="path2"></span></span></div>
    </div>
    <div class="overlay-bg"></div>
</div>