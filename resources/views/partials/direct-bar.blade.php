<div class="direct_bar_wrap">
    <div id="direct_bar" class="content-l">
        <div class="direct_bar_lang pull-left hide-mobile">
            <ul class="nav navbar-nav">
                <li><a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="icon_global"></span> {{ LaravelLocalization::getCurrentLocaleNative() }}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li class='{{ ((Lang::locale() === $localeCode) ? "" : "") }}'>
                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>

        <div class="direct_bar_list pull-right">
            <ul class="nav navbar-nav">
                <li><a href="https://hanoi.vietnamhouse.jp">@lang('front.top_menu_direct.hn_building')</a></li>
                <li><a href="#">@lang('front.top_menu_direct.hn_office')</a></li>
                <li><a href="https://vietnamhouse.jp">@lang('front.top_menu_direct.hcm_building')</a></li>
                <li class="active"><a href="/">@lang('front.top_menu_direct.hcm_office')</a></li>
            </ul>
        </div>
    </div>
</div>