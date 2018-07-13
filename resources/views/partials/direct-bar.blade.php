<div class="direct_bar_wrap">
    <div id="direct_bar" class="content-l">
        <div class="direct_bar_lang pull-left">
            <ul class="nav navbar-nav">
                <li><a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="icon_global"></span> {{ LaravelLocalization::getCurrentLocaleNative() }}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li class='{{ ((Lang::locale() === $localeCode) ? "active" : "") }}'>
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
                <li><a href="#">HCMC 住居</a></li>
                <li class="active"><a href="#">HCMC オフィス</a></li>
                <li><a href="#">HaNoi 住居</a></li>
                <li><a href="#">HaNoi オフィス</a></li>
            </ul>
        </div>
    </div>
</div>