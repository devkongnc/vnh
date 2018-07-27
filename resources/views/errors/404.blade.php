@extends('layout.base')

@section('styles')
	<style type="text/css">
		.top-bar-search {
			display: none;
		}
	</style>
@endsection

@section('content')
    <article class="page-not-found">
        <div class="content">
			<div class="content-s mrt-30">
				<div class="bg-white content-page">
					<div class="row">
						<div class="col-md-12">
							<h2 class="title-m center mrb-30">@lang('front.e404.title')</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<p>@lang('front.e404.detail')</p>
						</div>
					</div>
					<br>

                    <?php
                    $sitemap_structure = Config::get('sitemap.new_layout');
                    ?>
					<div class="row">
						@foreach ($sitemap_structure as $group)
							<div class="col-md-4 col-sm-4">
								<ul class="menu-list">
									@foreach ($group as $item)
										@if ($item === 'home')
											<li><a href="{{ route('home') }}">@lang('menu.home')</a></li>
										@elseif(isset($pages_by_id[$item]))
											<li>
												<a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[$item]->permalink) }}">
													{{ $pages_by_id[$item]->title }}
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</div>
						@endforeach
					</div>

				</div>
			</div>
        </div>
    </article>
@endsection
