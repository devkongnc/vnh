@extends('admin.layout.base')

@section('styles')
	<style type="text/css">
		.control-label {
			height: 34px;
		}
		.icheckbox_square-blue {
			background-color: white;
			margin-bottom: 6px;
		}
	</style>
@endsection

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.category')： @lang('admin.common.create new')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
                <li><a href="{{ action('Admin\CategoryController@index') }}">@lang('admin.entity.category')</a></li>
                <li class="active">@lang('admin.common.create new')</li>
            </ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<section class="col-lg-12">
					<div class="box box-solid">
						<div class="box-body nopadding">
							{!! Form::open(['action' => 'Admin\CategoryController@store', 'id' => 'create-highlight', 'class' => 'form-horizontal']) !!}
								@include('admin.category.content')
							{!! Form::close() !!}
						</div>
					</div>
				</section>
			</div>
		</section>
	</div>
	<div id="kcfinder_div_wrapper">
		<div id="kcfinder_div" class="kcfinder_div"></div>
	</div>
@endsection
