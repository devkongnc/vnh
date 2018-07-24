@extends('layout.base')

@section('content')

<!-- category -->
<div class="pickup">
	<div class="content-m">
		<div class="row">
			<div class="col-md-12 title-row">
				<h1 class="title-h">Pickup</h1>
				<h4 class="sub-title-h">@lang('front.special features of office')</h4>
				<a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/category') }}" class="blk-btn btn-140">@lang('front.feature list')</a>
			</div>
		</div>
		<div class="row">
			<?php foreach ($categories as $key => $category) { ?>
			<div class="col-md-3 col-sm-3">
				<div class="pickup-blk">
					<a href="{{ action('CategoryController@show', $category->permalink) }}">
						<div class="pickup-img">
							<img src="{{ asset($category->post_thumbnail) }}" alt="{{ $category->title }}" >
						</div>
						<p>{{ $category->title }}</p>
						<img src="{{ asset('images/new-layout/ar-b-s.png') }}" class="small-ar" >
						{{-- <span class="pickup-label new-label">NEW</span> --}}
						<div class="clearfix"></div>
					</a>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<!-- recommend -->
<div class="content-l">
	<div class="recommend">
		<div class="content-m">
			<div class="row">
				<div class="col-md-5 col-sm-5 center">
					<h1 class="title-h">Recommend</h1>
					<h4 class="sub-title-h">@lang('front.recommend_sub_title')</h4>

					<ul id="folio" class="folio-recommend" >
						<?php foreach ($stickies as $key => $office) { ?>
						<li class="estate-recommend" value="{{ $office->id }}"><a data-page="gal{{ $key }}" href="#gal{{ $key }}" class="gal-thumb">
								<span class="gal-label">{{ $office->product_id }}</span>
								<img src="{{ asset($office->post_thumbnail) }}" alt="{{ $office->title }}">
							</a>
						</li>
						<?php } ?>
					</ul>
				</div>
				<div class="col-md-7 col-sm-7">
					<div id="pages">
						<?php foreach ($stickies as $key => $office) { ?>
						<div id="gal{{ $key }}" class="page" data-page="gal{{ $key }}">
							<div class="folio-blk">
								<img src="{{ URL::to('/') }}{{ $office->post_thumbnail }}" alt="{{ $office->title }}" class="folio-big-img">
								<div class="info-desc">
									<h3 class="title-f">{{ $office->product_id }}</h3>
									<a href="#" class="like-btn btn-like like" data-id="{{ $office->product_id }}"><img src="{{ asset('images/new-layout/icon-heart.png') }}"></a>
									<span class="sub-title-f">{{ $office->title }}</span>

									<div class="info-blk">
										@if (!empty($office->price))
										<div class="fll">@lang('front.rent') <strong class="info-price">{{ $office->price }} {{  (!empty($office->price_max)) ?' ~ '.$office->price_max:'' }}</strong> USD / ㎡　（@lang('front.manage fee')）</div>
										@endif
										<div class="flr">@lang('entity.estate.deposit') {{ $office->deposit }}</div>
									</div>
									<div class="row">
										<div class="col-md-6"><strong>@lang('front.area')</strong>： {{ $office->area }}
										</div>
										<div class="col-md-6"><strong>@lang('front.location')</strong>： {{ $office->city }}
										</div>
									</div>
									<div class="row mrt-15">
										<div class="col-md-12">
												{{ strip_tags($office->description) }}
												<div class="center">
												<a href="{{ action('RealEstateController@show', $office->product_id) }}" class="more-btn white-btn">@lang('front.readmore')</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- benefit -->
{!! (!empty($benefit) ? (!is_null($benefit->html) ? $benefit->html: '') : '')  !!}

<!-- support -->
<div class="content-l">
	<div class="support">
		<div class="content-m">
			<div class="row">
				<div class="col-md-4 col-md-offset-2 col-sm-5">
					<div class="support-title">
					<img src="{{ asset('images/new-layout/icon-support.png') }}" >
					<h2>Support</h2>
					</div>
				</div>
				<div class="col-md-4 col-sm-7">
					<a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/support/area') }}" class="white-btn">@lang('front.support_footer.area')</a>
					<a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/support/step') }}" class="white-btn">@lang('front.support_footer.step')</a>
					<a href="{{ LaravelLocalization::getLocalizedURL($current_locale, '/company/contact') }}" class="white-btn">@lang('front.support_footer.contact')</a>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection
