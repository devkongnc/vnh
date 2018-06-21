@extends('admin.layout.base')

@section('styles')
	<style type="text/css">
		.table > thead > tr > td:nth-child(2),
		.table > tbody > tr > td:nth-child(2) {
			white-space: nowrap;
		}
	</style>
@stop

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.user')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\UserController@index') }}">@lang('admin.entity.user')</a></li>
				<li class="active">@lang('admin.common.list')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-solid">
						<div class="box-body">
							<p><a class="btn btn-primary" href="{{ action('Admin\UserController@create') }}" role="button">@lang('admin.common.create new')</a></p>
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th></th>
										<th>@lang('admin.user.role')</th>
										<th>@lang('admin.user.username')</th>
										<th>@lang('admin.user.email')</th>
										<th>@lang('admin.user.profile')</th>
										<th>@lang('admin.user.avatar')</th>
										<th>@lang('admin.common.actions')</th>
									</tr>
								</thead>
								<tbody>
								@foreach ($users as $user)
									<tr>
										<td></td>
										<td>@lang('admin.user.level.' . $user->level)</td>
										<td>{{ link_to(action('Admin\UserController@edit', $user->id), $user->name) }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ $user->profile }}</td>
										<td>@if(!empty($user->avatar)) <img src="{{ $user->post_thumbnail }}" width="120" height="120" class="img-responsive" alt=""> @endif</td>
										<td>
											{{ link_to(action('Admin\UserController@edit', $user->id), trans('admin.common.edit'), ['class' => 'btn btn-danger']) }}
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
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
