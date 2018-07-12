@extends('admin.layout.base')

@section('styles')
    <style type="text/css">
        .control-label {
            height: 34px;
        }
        .control-label[for="size_rangefor_search"],
        .control-label[for="size_rangefor_search"] + .col-sm-2 {
        	visibility: hidden;
        	position: absolute;
        	left: -9999px;
        }
        .form-group.single > .col-sm-2 {
        	margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.estate')： @lang('admin.common.create new')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\RealEstateController@index') }}">@lang('admin.entity.estate')</a></li>
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
							{!! Form::open(['action' => 'Admin\RealEstateController@store', 'id' => 'create-estate', 'role' => 'form', 'class' => 'form-horizontal']) !!}
								@include('admin.real-estate.content')
							{!! Form::close() !!}
						</div>
					</div>
				</section>
			</div>
		</section>
	</div>
	<div id="kcfinder_div_wrapper">
		<div id="kcfinder_div" class="kcfinder_div"></div>
		<div id="kcfinder_div2" class="kcfinder_div"></div>
	</div>
@endsection

@push('scripts')
	<script type="text/javascript">
		var _TOKEN = $('input[name="_token"]').val();
		dropzone_multi.on('sending', function(file, xhr, formData) {
        	formData.append("dir", 'images/' + _TOKEN);
        	formData.append('is_rectangle', true);
        });
	</script>
@endpush
