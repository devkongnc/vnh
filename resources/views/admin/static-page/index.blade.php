@extends('admin.layout.base')

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.page')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\PageController@index') }}">@lang('admin.entity.page')</a></li>
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
							<p class="statistic"><span style="margin-right: 1em;">@lang('admin.common.total') <span class="badge">{{ $pages->count() }}</span></span><span>@lang('admin.common.hidden') <span class="badge">{{ $pages->filter(function($value, $key) { return $value->status === \App\Page::VISIBILITY_HIDDEN; })->count() }}</span></span></p>
							<p><a class="btn btn-lg btn-primary" href="{{ action('Admin\PageController@create') }}" role="button">@lang('admin.common.create new')</a></p>
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
								@foreach ($pages as $page)
									<tr>
										<td></td>
										<td>{{ link_to(action('Admin\PageController@edit', $page->id), $page->title) }}</td>
										<td class="status">{!! $page->visibility !!}</td>
										<td>{{ $page->user->name or '' }}</td>
										<td>{{ $page->created_at }}</td>
										<td>
											{{ link_to(action('Admin\PageController@edit', $page->id), trans('admin.common.edit'), ['class' => 'btn btn-primary']) }}
											{{ link_to(LaravelLocalization::getLocalizedURL(null ,$page->permalink), trans('admin.common.view'), ['class' => 'btn btn-default', 'target' => '_blank']) }}
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
