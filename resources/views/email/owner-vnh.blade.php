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
        <p>@lang('email.contact us owner', [ 'name' => $data['name'] ])</p>
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
        	<a target="_blank" href="{{ route('home') }}">{{ route('home') }}</a><br />
        	@lang('email.address')
        </p>
    </body>
</html>
