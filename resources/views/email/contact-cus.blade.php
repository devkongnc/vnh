<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>@lang('email.customer', [ 'name' => $data['name'] ])</p>
        <p>&nbsp;</p>
        <p>@lang('email.inquiry')</p>
        <hr>
        <p>@lang('email.name') {{ $data['name'] }}</p>
        <p>@lang('email.email') {{ $data['email'] }}</p>
        <p>@lang('email.phone') {{ $data['phone'] }}</p>
        <p>@lang('email.message')</p>
        <p style="padding-left: 30px;">
        	{!! nl2br($data['message']) !!}
        </p>
        @if (count($estates) > 0)
        	<p>[@lang('email.estates id')]</p>
	        <p style="padding-left: 30px;">
	        	@foreach ($estates as $estate)
	        		<a href="{{ action('RealEstateController@show', $estate->product_id) }}">{{ $estate->product_id }}</a>
	        	@endforeach
	        </p>
        @endif
        <hr>
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
