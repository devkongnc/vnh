@extends('admin.layout.base')

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.user')： @lang('admin.common.create new')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\UserController@index') }}">@lang('admin.entity.user')</a></li>
				<li class="active">@lang('admin.common.create new')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<section class="col-lg-12">
					<div class="box box-solid">
						<div class="box-body nopadding">
							@include('partials.validations')
							<form id="create-user" action="{{ action('Admin\UserController@store') }}" method="POST" class="form-horizontal" role="form">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">@lang('admin.user.username')</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required="required">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-2 control-label">@lang('admin.user.email')</label>
									<div class="col-sm-3">
										<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required="required">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">@lang('admin.user.password')</label>
									<div class="col-sm-3">
										<input type="password" class="form-control" id="password" name="password" required="required">
									</div>
								</div>
								<div class="form-group">
									<label for="password_confirmation" class="col-sm-2 control-label">@lang('admin.user.confirm password')</label>
									<div class="col-sm-3">
										<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required="required">
									</div>
								</div>
								<div class="form-group">
									<label for="profile" class="col-sm-2 control-label">@lang('admin.user.profile')</label>
									<div class="col-sm-10">
										<textarea name="profile" id="profile" class="form-control" rows="3">{{ old('profile') }}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="avatar" class="col-sm-2 control-label">@lang('admin.common.set featured image')</label>
									<div class="col-sm-3">
										<div id='kcfinder-single-select'>
							                <img src="{{ asset($user->post_thumbnail) }}" class="img-responsive" alt="featured_image">
							                <input type="hidden" name="resource_id" value="{{ $user->post_thumbnail_id }}">
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
												App\User::USER_ADMIN   => 'Admin',
												App\User::USER_CONTENT => 'Content'
											), NULL, ['class' => 'form-control', 'placeholder' => '--', 'required' => ''])
										}}
									</div>
								</div>
								<div class="form-group" style="margin-bottom: 0;">
									<div class="col-sm-3 col-sm-offset-2">
										<button type="submit" class="btn btn-primary">@lang('admin.common.save')</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>
		</section>
	</div>
	<div id="kcfinder_div_wrapper"><div id="kcfinder_div" class="kcfinder_div"></div></div>
@endsection
