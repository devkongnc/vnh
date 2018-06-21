@extends('admin.layout.base')

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.estate')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\RealEstateController@index') }}">@lang('admin.entity.estate')</a></li>
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
							<p class="statistic"><span style="margin-right: 1em;">@lang('admin.common.total') <span class="badge">{{ $total }}</span></span><span>@lang('admin.common.hidden') <span class="badge">{{ $hidden }}</span></span></p>
							<p class="pull-left"><a class="btn btn-primary" href="{{ action('Admin\RealEstateController@create') }}" role="button">@lang('admin.common.create new')</a></p>
							<form action="{{ action('Admin\RealEstateController@export') }}" method="POST" id="export" class="form-inline pull-right" role="form">
								{{ csrf_field() }}
								<button type="submit" class="btn btn-primary">@lang('admin.common.export')</button>
							</form>
							<div class="clearfix"></div>
							<form action="" method="GET" class="row">
								@foreach($above->filter(function($value, $key) { return in_array($key, ['area', 'type']); }) as $key => $data)
								<p class="col-sm-2 no-padding-right">
									<select id="term-{{$key}}" class="selectpicker form-control" autocomplete="off">
					                    <option value="" selected="" disabled="">{{ getLocaleValue($data['name']) }}</option>
					                    @foreach($data['values'] as $index => $value)
					                        <option value="{{$index}}">{{ getLocaleValue($value) }}</option>
					                    @endforeach
					                </select>
								</p>
								@endforeach
							</form>
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th class="no-sort"></th>
										<th>ID</th>
										<th class="no-sort">@lang('admin.common.title')</th>
										<th>@lang('admin.apartment.price')</th>
										<th>@lang('admin.common.status')</th>
										<th>@lang('admin.common.sticky')</th>
										<th class="no-sort">@lang('admin.common.created by')</th>
										<th>@lang('admin.common.created at')</th>
										<th class="no-sort">@lang('admin.common.actions')</th>
									</tr>
								</thead>
								<tbody>
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
		    var table = $('table').DataTable({
		    	"processing": true,
		        "serverSide": true,
		        "ajax": {
		        	url: '{{ action('Admin\RealEstateController@index') }}',
		        	data: function(d) {
		        		d.area = $('#term-area').val();
		        		d.type = $('#term-type').val();
		        	}
		        },
		        "columnDefs": [
					{ orderable: false, targets: 'no-sort' },
					{ className: 'select-checkbox', targets: 0 },
					{ className: 'text-center', targets: 5 }
				]
		    });

		    $('.selectpicker.form-control').change(function(event) {
                table.ajax.reload();
            });
		} );
	</script>
@endsection
