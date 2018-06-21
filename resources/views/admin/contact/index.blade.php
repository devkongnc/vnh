@extends('admin.layout.base')

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.contact')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li class="active">@lang('admin.entity.contact')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<section class="col-lg-12">
					<div class="box box-solid">
						<div class="box-body nopadding">
							@include('partials.validations')
							<p class="statistic"><span style="margin-right: 1em;">@lang('admin.common.total') <span class="badge">{{ $contacts->count() }}</span></span><span>@lang('admin.contact.unread') <span class="badge">{{ $contacts->filter(function($value, $key) { return (boolean) $value->unread === true; })->count() }}</span></span></p>
							<form action="{{ action('Admin\ContactController@export') }}" method="POST" id="export" class="form-inline" role="form">
								{{ csrf_field() }}
								<button type="submit" class="btn btn-primary">@lang('admin.common.export')</button>
							</form>
							<p></p>
							<div class="clearfix"></div>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>@lang('admin.user.fullname')</th>
										<th>@lang('admin.user.phone')</th>
										<th>@lang('admin.user.email')</th>
										<th>@lang('admin.common.status')</th>
										<th>@lang('admin.common.created at')</th>
									</tr>
								</thead>
								<tbody>
								@foreach ($contacts as $contact)
									<tr>
										<td></td>
										<td>{{ link_to(action('Admin\ContactController@show', $contact->id), $contact->name) }}</td>
										<td>{{ $contact->phone }}</td>
										<td>{{ $contact->email }}</td>
										<td>{!! $contact->status !!}</td>
										<td>{{ $contact->created_at }}</td>
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
