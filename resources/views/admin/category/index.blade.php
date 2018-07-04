@extends('admin.layout.base')

@section('styles')
	<style type="text/css">
		.images-container > .item {
			cursor: default;
		}
		.images-container > .item > .img-responsive {
			cursor: move;
			margin-bottom: 2em;
		}
		.box-body > .tab-content {
			padding-top: 30px;
		}
		button.set-featured {
			text-decoration: none;
		}
	</style>
@stop

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.category')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\CategoryController@index') }}">@lang('admin.entity.category')</a></li>
				<li class="active">@lang('admin.common.list')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<section class="col-lg-12">
					<div class="box box-solid">
						<div class="box-body">
							@include('partials.validations')
							<p class="statistic">
								<span style="margin-right: 1em;">@lang('admin.common.total')
									<span class="badge">{{ $categories->count() }}</span>
								</span>
								<span>@lang('admin.common.hidden')
									<span class="badge">{{ $categories->filter(function($value) { return $value->status === \App\Category::VISIBILITY_HIDDEN; })->count() }}</span>
								</span>
							</p>
							<p><a class="btn btn-lg btn-primary" href="{{ action('Admin\CategoryController@create') }}" role="button">新規登録</a></p>
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th></th>
										<th>@lang('admin.common.title')</th>
										<th>@lang('admin.common.status')</th>
										<th>@lang('admin.common.created by')</th>
										<th>@lang('admin.common.created at')</th>
										<th>@lang('admin.common.actions')</th>
									</tr>
								</thead>
								<tbody>
									@foreach($categories as $index => $category)
									<tr>
										<td></td>
										<td>{{ link_to(action('Admin\CategoryController@edit', $category->id), $category->title) }}</td>
										<td class="status">{!! $category->visibility !!}</td>
										<td>{{ $category->user->name or '' }}</td>
										<td>{{ $category->created_at }}</td>
										<td>
											{{ link_to(action('Admin\CategoryController@edit', $category->id), trans('admin.common.edit'), ['class' => 'btn btn-primary']) }}
											{{ link_to(action('CategoryController@show', $category->permalink), trans('admin.common.view'), ['class' => 'btn btn-default', 'target' => '_blank']) }}
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="box box-solid">
						<div class="box-body">
							<h3 class="block-title">TOPバナー</h3>
							{{--<ul class="nav nav-tabs" role="tablist">--}}
								{{--<li role="presentation" class="{{ option('home_banner') === 'slider' ? 'active' : '' }}">--}}
									{{--<a href="#home-slider" aria-controls="home-slider" role="tab" data-toggle="tab">Slider</a>--}}
								{{--</li>--}}
								{{--<li role="presentation" class="{{ option('home_banner') === 'video' ? 'active' : '' }}">--}}
									{{--<a href="#home-video" aria-controls="home-video" role="tab" data-toggle="tab">Video</a>--}}
								{{--</li>--}}
							{{--</ul>--}}
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane {{ option('home_banner') === 'slider' ? 'active' : '' }}" id="home-slider">
									<form action="{{ action('Admin\CategoryController@home', 'home_slider') }}" method="POST">
										{{ csrf_field() }}
										<div class="form-group">
											<button type="button" class="btn btn-default insert-media add_media set-featured" data-toggle="modal" href="#modal-upload"><i class="fa fa-picture-o" aria-hidden="true"></i> @lang('admin.common.upload btn')</button>
										</div>
										<div class="images-container sortable">
										@if (!empty($slides) && count($slides))
										@foreach ($slides as $index => $slide)
											{{-- */	$id = $slide->id; /* --}}
											<div class="item">
												<input type="hidden" value="{{ $slide->id }}" name="images[]">
												<img alt="" class="img-responsive" src="{{ isset($resources[$slide->id]) ? asset($resources[$slide->id]->thumbnail) : '' }}">
												<button type="button" class="resource-delete">X</button>
												<div class="form-group">
													<ul class="property-languages list-unstyled">
													    @foreach($all_locales as $localeCode => $properties)
													        <li class="{{ ($current_locale == $localeCode) ? 'active' : '' }}">
													            <a href="#first-{{ "{$id}-{$localeCode}" }}" data-toggle="tab" data-tab-lang="{{ $localeCode }}">{{{ $properties['native'] }}}</a>
													        </li>
													    @endforeach
													</ul>
													<div class="tab-content">
													    @foreach($all_locales as $localeCode => $properties)
													        <div class="tab-pane {{ ($current_locale == $localeCode) ? 'active' : '' }}" id="first-{{ "{$id}-{$localeCode}" }}">
													            {{ Form::text("first[{$slide->id}][{$localeCode}]", array_get(getLocaleStringAsArray($slide->first), $localeCode), ['class' => 'form-control', 'data-lang' => $localeCode]) }}
													        </div>
													    @endforeach
													</div>
												</div>
												<div class="form-group">
													<ul class="property-languages list-unstyled">
													    @foreach($all_locales as $localeCode => $properties)
													        <li class="{{ ($current_locale == $localeCode) ? 'active' : '' }}">
													            <a href="#second-{{ "{$id}-{$localeCode}" }}" data-toggle="tab" data-tab-lang="{{ $localeCode }}">{{{ $properties['native'] }}}</a>
													        </li>
													    @endforeach
													</ul>
													<div class="tab-content">
													    @foreach($all_locales as $localeCode => $properties)
													        <div class="tab-pane {{ ($current_locale == $localeCode) ? 'active' : '' }}" id="second-{{ "{$id}-{$localeCode}" }}">
													            {{ Form::text("second[{$slide->id}][{$localeCode}]", array_get(getLocaleStringAsArray($slide->second), $localeCode), ['class' => 'form-control', 'data-lang' => $localeCode]) }}
													        </div>
													    @endforeach
													</div>
												</div>
											</div>
											@endforeach
											@endif
										</div>
										<div class="form-group">
										    <div class="col-sm-3 no-padding">
										        <button type="submit" class="block-full-width btn btn-lg btn-primary">@lang('admin.common.save')</button>
										    </div>
										</div>
									</form>
								</div>
								{{--<div role="tabpanel" class="tab-pane {{ option('home_banner') === 'video' ? 'active' : '' }}" id="home-video">--}}
									{{--<form action="{{ action('Admin\CategoryController@home', 'home_video') }}" method="POST" enctype="multipart/form-data">--}}
										{{--{{ csrf_field() }}--}}
										{{--@if ($video and $video->url)--}}
											{{--<div class="form-group">--}}
												{{--<video src="{{ $video->url }}" controls></video>--}}
											{{--</div>--}}
										{{--@endif--}}
										{{--<div class="form-group">--}}
											{{--<input type="file" name="video">--}}
										{{--</div>--}}
										{{--<div class="row form-group">--}}
											{{--<div class="col-sm-6">--}}
												{{--<ul class="property-languages list-unstyled">--}}
												    {{--@foreach($all_locales as $localeCode => $properties)--}}
												        {{--<li class="{{ ($current_locale == $localeCode) ? 'active' : '' }}">--}}
												            {{--<a href="#video-first-{{ $localeCode }}" data-toggle="tab" data-tab-lang="{{ $localeCode }}">{{{ $properties['native'] }}}</a>--}}
												        {{--</li>--}}
												    {{--@endforeach--}}
												{{--</ul>--}}
												{{--<div class="tab-content">--}}
												    {{--@foreach($all_locales as $localeCode => $properties)--}}
												        {{--<div class="tab-pane {{ ($current_locale == $localeCode) ? 'active' : '' }}" id="video-first-{{ $localeCode }}">--}}
												            {{--{{ Form::text("first[{$localeCode}]", array_get($video ? getLocaleStringAsArray($video->first) : [], $localeCode), ['class' => 'form-control', 'data-lang' => $localeCode]) }}--}}
												        {{--</div>--}}
												    {{--@endforeach--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
										{{--<div class="row">--}}
											{{--<div class="col-sm-6">--}}
												{{--<ul class="property-languages list-unstyled">--}}
												    {{--@foreach($all_locales as $localeCode => $properties)--}}
												        {{--<li class="{{ ($current_locale == $localeCode) ? 'active' : '' }}">--}}
												            {{--<a href="#video-second-{{ $localeCode }}" data-toggle="tab" data-tab-lang="{{ $localeCode }}">{{{ $properties['native'] }}}</a>--}}
												        {{--</li>--}}
												    {{--@endforeach--}}
												{{--</ul>--}}
												{{--<div class="tab-content">--}}
												    {{--@foreach($all_locales as $localeCode => $properties)--}}
												        {{--<div class="tab-pane {{ ($current_locale == $localeCode) ? 'active' : '' }}" id="video-second-{{ $localeCode }}">--}}
												            {{--{{ Form::text("second[{$localeCode}]", array_get($video ? getLocaleStringAsArray($video->second) : [], $localeCode), ['class' => 'form-control', 'data-lang' => $localeCode]) }}--}}
												        {{--</div>--}}
												    {{--@endforeach--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
										{{--<div class="row">--}}
										    {{--<div class="col-sm-3">--}}
										        {{--<button type="submit" class="block-full-width btn btn-lg btn-primary">@lang('admin.common.save')</button>--}}
										    {{--</div>--}}
										{{--</div>--}}
									{{--</form>--}}
								{{--</div>--}}
							</div>
						</div>
					</div>
					{{--<div class="box box-solid">--}}
						{{--<form action="{{ action('Admin\CategoryController@home', 'partner') }}" method="POST" class="box-body">--}}
							{{--{{ csrf_field() }}--}}
							{{--<h3 class="block-title">FOOTER パートナー</h3>--}}
							{{--<div class="form-group row">--}}
								{{--<div class="col-sm-9">--}}
									{{--{{ Form::textarea('partner', option('partner'), ['class' => 'form-control']) }}--}}
								{{--</div>--}}
							{{--</div>--}}
							{{--<div class="form-group">--}}
							    {{--<div class="col-sm-3 no-padding">--}}
							        {{--<button type="submit" class="block-full-width btn btn-lg btn-primary">@lang('admin.common.save')</button>--}}
							    {{--</div>--}}
							{{--</div>--}}
						{{--</form>--}}
					{{--</div>--}}
					<div class="box box-solid">
						<form action="{{ action('Admin\CategoryController@home', 'robots') }}" method="POST" class="box-body">
							{{ csrf_field() }}
							<h3 class="block-title">Robots.txt</h3>
							<div class="form-group row">
								<div class="col-sm-9">
									{{ Form::textarea('robots', $robots, ['class' => 'form-control']) }}
								</div>
							</div>
							<div class="form-group">
							    <div class="col-sm-3 no-padding">
							        <button type="submit" class="block-full-width btn btn-lg btn-primary">@lang('admin.common.save')</button>
							    </div>
							</div>
						</form>
					</div>
				</section>
			</div>
		</section>
	</div>
	<div id="kcfinder_div_wrapper"><div id="kcfinder_div" class="kcfinder_div"></div></div>
@endsection

@section('scripts')
	<script type="text/javascript">
		String.prototype.capitalizeFirstLetter = function() {
		    return this.charAt(0).toUpperCase() + this.slice(1);
		};

		function lang_input(name, id) {
			var html_id = name + '-' + id;
			return '\
				<div class="form-group">\
					<ul class="property-languages list-unstyled">\
						<li class="' + ((current_locale === 'ja') ? 'active' : '') + '"><a href="#' + html_id +'-ja" data-toggle="tab" data-tab-lang="ja">日本語</a></li>\
						<li class="' + ((current_locale === 'en') ? 'active' : '') + '"><a href="#' + html_id +'-en" data-toggle="tab" data-tab-lang="en">English</a></li>\
						<li class="' + ((current_locale === 'vi') ? 'active' : '') + '"><a href="#' + html_id +'-vi" data-toggle="tab" data-tab-lang="vi">Tiếng Việt</a></li>\
					</ul>\
					<div class="tab-content">\
						<div class="tab-pane' + ((current_locale === 'ja') ? ' active' : '') + '" id="' + html_id +'-ja"><input class="form-control" data-lang="ja" name="' + name + '[' + id + '][ja]" type="text"></div>\
						<div class="tab-pane' + ((current_locale === 'en') ? ' active' : '') + '" id="' + html_id +'-en"><input class="form-control" data-lang="en" name="' + name + '[' + id + '][en]" type="text"></div>\
						<div class="tab-pane' + ((current_locale === 'vi') ? ' active' : '') + '" id="' + html_id +'-vi"><input class="form-control" data-lang="vi" name="' + name + '[' + id + '][vi]" type="text"></div>\
					</div>\
				</div>\
			';
		}

        dropzone_single.destroy();
        dropzone_single = new Dropzone("#upload-single", {
		    url: '{{ LaravelLocalization::getNonLocalizedURL(action('Admin\ResourceController@upload')) }}',
            maxFiles:1,
		    maxFilesize: 3,
		    paramName: 'upload[]',
		    uploadMultiple: false,
		    thumbnailWidth: 150,
		    thumbnailHeight: 150,
		    acceptedFiles: 'image/*',
		    sending: function(file, xhr, formData) {
		        formData.append("dir", 'home');
		    },
		    success: function(files, response) {
		        images_html = '';
		        console.log(response);
		        for (var i = 0; i < response.length; i++) {
		            images_html += '\
			            <div class="item">\
			            	<img src="' + response[i].url + '" class="img-responsive" alt="">\
			            	<input type="hidden" name="images[]" value="' + response[i].id + '">\
			            	<button class="resource-delete" type="button">X</button>' +
			            	lang_input('first', response[i].id) +
			            	lang_input('second', response[i].id) +
			            '</div>\
		            ';
		        }
		        $images_container.html(images_html);
		    }
		});

		$('table').DataTable();
	</script>
@endsection
