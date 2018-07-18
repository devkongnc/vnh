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

@section('view-page')
	<a class="btn btn-info view-page" href="{{ action('RealEstateController@show', $estate->product_id) }}"
	   target="_blank">@lang('admin.common.view')</a>
@endsection

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.estate')： @lang('admin.common.edit')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\RealEstateController@index') }}">@lang('admin.entity.estate')</a></li>
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
							{!! Form::open(['action' => ['Admin\RealEstateController@update', $estate->id],
								'method' => 'PUT', 'class' => 'form-horizontal',
								'role' => 'form', 'id' => 'create-estate']) !!}
								@include('admin.real-estate.content')
							{!! Form::close()!!}
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
		$('.btn-danger').click(function(event) {
        	event.preventDefault();
        	if (!confirm('{{ trans('admin.common.Are you sure?') }}')) return;
			$('<form>', {
                'action': '{{ action('Admin\RealEstateController@destroy', $estate->id) }}',
                'method': 'POST',
                'html': '<input name="_method" value="DELETE" ' +
				'type="hidden"><input name="_token" value="' + _TOKEN + '" type="hidden">'
            }).appendTo('body').submit();
        });

        dropzone_multi.on('sending', function(file, xhr, formData) {
        	formData.append('dir', 'images/{{ $estate->product_id }}');
        	formData.append('is_rectangle', true);
        });
	</script>
@endpush
