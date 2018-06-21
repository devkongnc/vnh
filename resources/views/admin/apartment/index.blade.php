@extends('admin.layout.base')

@section('styles')
	<style type="text/css">
		.dataTable > tbody > tr > td {
			white-space: nowrap;
		}
	</style>
@stop

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.apartment')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\ApartmentController@index') }}">@lang('admin.entity.apartment')</a></li>
				<li class="active">@lang('admin.common.list')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<section class="col-lg-12">
					<div class="box box-solid">
						<div class="box-body nopadding">
							@include('partials.validations')
							<p class="statistic"><span style="margin-right: 1em;">@lang('admin.common.total') <span class="badge">{{ $apartments->count() }}</span></span><span>@lang('admin.common.hidden') <span class="badge">{{ $apartments->filter(function($value, $key) { return $value->status === \App\Apartment::VISIBILITY_HIDDEN; })->count() }}</span></span></p>
							<p class="pull-left"><a class="btn btn-primary" href="{{ action('Admin\ApartmentController@create') }}" role="button">@lang('admin.common.create new')</a></p>
							<form action="{{ action('Admin\ApartmentController@export') }}" method="POST" id="export" class="form-inline pull-right" role="form">
								{{ csrf_field() }}
								<button type="submit" class="btn btn-primary">@lang('admin.common.export')</button>
							</form>
							<div class="clearfix"></div>
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th></th>
										<th>ID</th>
										<th>@lang('admin.review.title')</th>
										<th>@lang('admin.apartment.district')</th>
										<th>@lang('admin.common.status')</th>
										<th>@lang('admin.common.created by')</th>
										<th>@lang('admin.common.created at')</th>
										<th>@lang('admin.common.actions')</th>
									</tr>
								</thead>
								<tbody>
								@foreach ($apartments as $apartment)
									<tr>
										<td></td>
										<td>{{ $apartment->id }}</td>
										<td>{{ link_to(action('Admin\ApartmentController@edit', $apartment->id), $apartment->title) }}</td>
										<td>{{ $apartment->area_text }}</td>
										<td class="status">{!! $apartment->visibility !!}</td>
										<td>{{ $apartment->user->name or '' }}</td>
										<td>{{ $apartment->created_at }}</td>
										<td>
											{{ link_to(action('Admin\ApartmentController@edit', $apartment->id), trans('admin.common.edit'), ['class' => 'btn btn-primary']) }}
											{{ link_to(action('ApartmentController@show', $apartment->permalink), trans('admin.common.view'), ['class' => 'btn btn-default', 'target' => '_blank']) }}
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
		$(document).ready(function() {
		    $('table').DataTable();
		} );
	</script>
@endsection
