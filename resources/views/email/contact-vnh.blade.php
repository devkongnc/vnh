<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>@lang('email.contact us', [ 'name' => $data['name'] ])</p>
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
        	<p>@lang('email.estates id')</p>
	        <p style="padding-left: 30px;">
	        	@foreach ($estates as $estate)
	        		<a href="{{ action('RealEstateController@show', $estate->product_id) }}">{{ $estate->product_id }}</a>
	        	@endforeach
	        </p>
        @endif
        <hr>
        <p>
        	<a target="_blank" href="{{ route('home') }}">{{ route('home') }}</a><br />
        	@lang('email.address')
        </p>
    </body>
</html>
