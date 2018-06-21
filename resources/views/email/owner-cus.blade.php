<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style type="text/css">
            p.empty {
                height: 1px;
            }
        </style>
    </head>
    <body>
        <p>@lang('email.customer owner', [ 'name' => $data['name'] ])</p>
        <p class="empty"></p>
        <p>@lang('email.owner')</p>
        <hr>
        <table>
            <tr>
                <td width="100">@lang('email.name')</td>
                <td>{{ $data['name'] }}</td>
            </tr>
            <tr>
                <td>@lang('email.phone')</td>
                <td>{{ $data['phone'] }}</td>
            </tr>
            <tr>
                <td>@lang('email.email')</td>
                <td>{{ $data['email'] }}</td>
            </tr>
        </table>
        <p class="empty"></p>
        <p>@lang('email.property')</p>
        <hr>
        <table>
            @foreach ($terms as $key => $value)
                <tr>
                    <td width="100">{{ $current_locale === 'ja' ? '〔' : '[' }}{{ getLocaleValue($config[$key]['name'], $current_locale) }}{{ $current_locale === 'ja' ? '〕' : ']' }}</td>
                    <td>
                        @if ($config[$key]['type'] === 'text' or $config[$key]['type'] === 'single') {{ $estate->{$key} }}
                        @else
                            {{ implode(', ', array_map(function($item) use($key, $config, $current_locale) { return getLocaleValue($config[$key]['values'][$item], $current_locale); }, $value)) }}
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>@lang('email.message')</td>
                <td>{!! nl2br($data['message']) !!}</td>
            </tr>
        </table>
        <hr>
        <p class="empty"></p>
        <p>
            @lang('email.support')<br />
            <a target="_blank" href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[3]->permalink) }}">{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[3]->permalink) }}</a><br />
            @lang('email.support text')
        </p>
        <p>
            @lang('email.blog')<br />
            <a target="_blank" href="{{ action('ReviewController@index') }}">{{ action('ReviewController@index') }}</a><br />
            @lang('email.blog text')
        </p>
        <p>@lang('email.notice')</p>
        <hr>
        <p>
            @lang('email.contact form') <a target="_blank" href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[11]->permalink) }}">{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[11]->permalink) }}</a><br />
            @lang('email.email') hello@vietnamhouse.jp<br />
            @lang('email.phone') 08-3911-2100
        </p>
        <hr>
        <p>
        	<a target="_blank" href="{{ route('home') }}">{{ route('home') }}</a><br />
        	@lang('email.address')
        </p>
    </body>
</html>
