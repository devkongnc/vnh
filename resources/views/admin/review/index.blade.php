@extends('admin.layout.base')

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.review')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\ReviewController@index') }}">@lang('admin.entity.review')</a></li>
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
							<p class="statistic"><span style="margin-right: 1em;">@lang('admin.common.total') <span class="badge">{{ $reviews->count() }}</span></span><span>@lang('admin.common.hidden') <span class="badge">{{ $reviews->filter(function($value, $key) { return $value->status === \App\Review::VISIBILITY_HIDDEN; })->count() }}</span></span></p>
							<p class="pull-left"><a class="btn btn-primary" href="{{ action('Admin\ReviewController@create') }}" role="button">@lang('admin.common.create new')</a></p>
							<form action="{{ action('Admin\ReviewController@export') }}" method="POST" id="export" class="form-inline pull-right" role="form">
								{{ csrf_field() }}
								<button type="submit" class="btn btn-primary">@lang('admin.common.export')</button>
							</form>
							<div class="clearfix"></div>
							<form action="{{ action('Admin\ReviewController@index') }}" method="GET" class="row category-filter">
								<p class="col-sm-2">{{ Form::select('category', trans('admin.review.categories'), Input::get('category'), ['class' => 'selectpicker form-control', 'placeholder' => trans('admin.review.category')]) }}</p>
							</form>
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th></th>
										<th>@lang('admin.common.title')</th>
										<th>@lang('admin.review.category')</th>
										<th>@lang('admin.review.visible title')</th>
										<th>@lang('admin.common.created by')</th>
										{{--<th>@lang('admin.common.created at')</th>--}}
										<th>@lang('admin.common.actions')</th>
									</tr>
								</thead>
								<tbody>
									@foreach($reviews as $review)
										<tr>
											<td></td>
											<td>{{ link_to(action('Admin\ReviewController@edit', $review->id), $review->draft ? '(' . trans('admin.review.state.draft') . ') ' . $review->title : $review->title) }}</td>
											<td>
												@foreach($review->categoriesName as $index => $name)
													@if ($index > 0) - @endif{{ $name }}
												@endforeach
											</td>
											<td class="status">{!! $review->visibility !!}</td>
											<td>{{ $review->user->name or '' }}</td>
											{{--<td>{{ $review->created_at }}</td>--}}
											<td>
												{{ link_to(action('Admin\ReviewController@edit', $review->id), trans('admin.common.edit'), ['class' => 'btn btn-primary']) }}
												{{ link_to($review->url, trans('admin.common.view'), ['class' => 'btn btn-default', 'target' => '_blank']) }}
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>
		</section>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		var _TOKEN = $('input[name="_token"]').val();
		$(document).ready(function() {
		    $('table').DataTable();

		    $('.category-filter select').on('change', function(event) {
		    	if ($(this).val() === '') window.location = '{{ action('Admin\ReviewController@index') }}';
		    	else $(this).parents('form').submit();
		    });
		} );
	</script>
@endsection
