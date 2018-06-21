@extends('admin.layout.base')

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.user')： @lang('admin.common.edit')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\UserController@index') }}">@lang('admin.entity.user')</a></li>
				<li class="active">@lang('admin.common.edit')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<section class="col-lg-12">
					<div class="box box-solid">
						<div class="box-body nopadding">
							@include('partials.validations')
							<form id="create-user" action="{{ action('Admin\UserController@update', $user->id) }}" method="POST" class="form-horizontal" role="form">
								{{ method_field('PUT') }}
								{{ csrf_field() }}
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">@lang('admin.user.username')</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required="required">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-2 control-label">@lang('admin.user.email')</label>
									<div class="col-sm-3">
										<input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required="required">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">@lang('admin.user.password')</label>
									<div class="col-sm-3">
										<input type="password" class="form-control" id="password" name="password">
									</div>
								</div>
								<div class="form-group">
									<label for="password_confirmation" class="col-sm-2 control-label">@lang('admin.user.confirm password')</label>
									<div class="col-sm-3">
										<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
									</div>
								</div>
								<div class="form-group">
									<label for="profile" class="col-sm-2 control-label">@lang('admin.user.profile')</label>
									<div class="col-sm-10">
										<textarea name="profile" id="profile" class="form-control" rows="3">{{ $user->profile }}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="avatar" class="col-sm-2 control-label">@lang('admin.common.set featured image')</label>
									<div class="col-sm-3">
										<div id='kcfinder-single-select'>
											<img src="{{ $user->post_thumbnail }}" class="img-responsive" alt="featured_image">
							                <input type="hidden" name="avatar" value="{{ $user->post_thumbnail_id }}">
							                <a class="set-featured{{ $user->post_thumbnail_id === '' ? '' : ' hidden' }}" data-toggle="modal" href="#modal-upload">@lang('admin.common.set featured image')</a>
							                <a class="remove-featured{{ $user->post_thumbnail_id === '' ? ' hidden' : '' }}">@lang('admin.common.remove featured image')</a>
							            </div>
									</div>
								</div>
								<div class="form-group">
									<label for="level" class="col-sm-2 control-label">@lang('admin.user.role')</label>
									<div class="col-sm-3">
										{{
											Form::select('level', array(
												App\User::USER_ADMIN  => 'Admin',
												App\User::USER_CONTENT => 'Content'
											), $user->level, ['class' => 'form-control', 'placeholder' => '--', 'required' => ''])
										}}
									</div>
								</div>
								<div class="form-group" style="margin-bottom: 0;">
									<div class="col-sm-3 col-sm-offset-2">
										<button type="submit" class="btn btn-primary">@lang('admin.common.edit')</button>
									</div>
									@if (auth()->user()->isAdmin && $user->id != auth()->user()->id)
										<div class="col-sm-3" id="delete-user">
											<button type="button" class="btn btn-danger">@lang('admin.common.delete')</button>
										</div>
									@endif
								</div>
							</form>
							@if (auth()->user()->isAdmin && $user->id != auth()->user()->id)
							<form action="{{ action('Admin\UserController@destroy', $user->id) }}" method="POST" id="delete-user-form">
								<input type="hidden" name="_method" value="DELETE">
								{{ csrf_field() }}
							</form>
							@endif
						</div>
					</div>
				</section>
			</div>
		</section>
	</div>
	<div id="kcfinder_div_wrapper"><div id="kcfinder_div" class="kcfinder_div"></div></div>
@endsection

@push('scripts')
	<script>
		$("#delete-user").click(function() {
			if (confirm('{{ trans('admin.common.Are you sure?') }}')) {
				$("#delete-user-form").submit();
			}
		});
	</script>
@endpush