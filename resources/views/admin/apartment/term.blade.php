@extends('admin.layout.base')

@section('styles')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/rowreorder/1.1.2/css/rowReorder.dataTables.min.css">
	<style type="text/css">
		h3 {
			border-bottom: 2px solid black;
			padding-bottom: 5px;
		}
		.radio {
			margin-left: 20px;
		}
		.radio > label {
			margin-right: 30px;
			padding-left: 0;
		}
		.radio > label > .iradio_square-blue {
			margin-right: 5px;
		}
		table > tbody > tr > td:last-child {
			text-align: right;
		}
	</style>
@endsection

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.apartment')： @lang('admin.common.term')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\ApartmentController@index') }}">@lang('admin.entity.apartment')</a></li>
				<li class="active">@lang('admin.common.term')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<section class="col-lg-12">
					<div class="row">
						<div class="col-xs-12">@include('partials.validations')</div>
						<div class="col-sm-2"><button type="button" class="btn btn-primary" data-toggle="modal" href='#modal-term-edit'>@lang('admin.common.create new')</button></div>
						<div class="clearfix"></div>
						<div class="col-md-6">
							<h3>@lang('admin.apartment.basic')</h3>
							<table class="table table-hover term">
								<tbody>
									{{--*/ $basic = array_filter(Config::get('apartment'), function($item) { return $item['group'] == 'basic'; }) /*; --}}
									@foreach($basic as $key => $value)
										<tr>
											<td>{{ \App\Term::getLocaleValue($value['name']) }}</td>
											<td>
												<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" href="#modal-term-edit" data-mode="edit" data-key="basic.{{$key}}">@lang('admin.common.edit')</button>
												<button type="button" class="btn btn-sm btn-danger" data-key="basic.{{ $key }}" data-name="{{ \App\Term::getLocaleValue($value['name']) }}" data-toggle="modal" href="#deleteModal">@lang('admin.common.delete')</button>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<h3>@lang('admin.apartment.equipment')</h3>
							<table class="table table-hover term">
								<tbody>
									{{--*/ $equipment = array_filter(Config::get('apartment'), function($item) { return $item['group'] == 'equipment'; }) /*; --}}
									@foreach($equipment as $key => $value)
										<tr>
										<td>{{ \App\Term::getLocaleValue($value['name']) }}</td>
										<td>
											<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" href="#modal-term-edit" data-mode="edit" data-key="equipment.{{$key}}">@lang('admin.common.edit')</button>
											<button type="button" class="btn btn-sm btn-danger" data-key="equipment.{{ $key }}" data-name="{{ \App\Term::getLocaleValue($value['name']) }}" data-toggle="modal" href="#deleteModal">@lang('admin.common.delete')</button>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-6">
							<h3>@lang('admin.apartment.indoor_facilities')</h3>
							<table class="table table-hover term">
								<tbody>
								{{--*/ $indoor_facilities = array_filter(Config::get('apartment'), function($item) { return $item['group'] == 'indoor_facilities'; }) /*; --}}
								@foreach($indoor_facilities as $key => $value)
									<tr>
										<td>{{ \App\Term::getLocaleValue($value['name']) }}</td>
										<td>
											<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" href="#modal-term-edit" data-mode="edit" data-key="indoor_facilities.{{$key}}">@lang('admin.common.edit')</button>
											<button type="button" class="btn btn-sm btn-danger" data-key="indoor_facilities.{{ $key }}" data-name="{{ \App\Term::getLocaleValue($value['name']) }}" data-toggle="modal" href="#deleteModal">@lang('admin.common.delete')</button>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<h3>@lang('admin.apartment.children_facilities')</h3>
							<table class="table table-hover term">
								{{--*/ $children_facilities = array_filter(Config::get('apartment'), function($item) { return $item['group'] == 'children_facilities'; }) /*; --}}
								<tbody>
								@foreach($children_facilities as $key => $value)
									<tr>
										<td>{{ \App\Term::getLocaleValue($value['name']) }}</td>
										<td>
											<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" href="#modal-term-edit" data-mode="edit" data-key="children_facilities.{{$key}}">@lang('admin.common.edit')</button>
											<button type="button" class="btn btn-sm btn-danger" data-key="children_facilities.{{ $key }}" data-name="{{ \App\Term::getLocaleValue($value['name']) }}" data-toggle="modal" href="#deleteModal">@lang('admin.common.delete')</button>
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
		<div class="modal fade" id="modal-term-edit">
			<div class="modal-dialog">
				<form id="create-term" class="modal-content" action="" method="POST" role="form">

				</form>
			</div>
		</div>
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    {!! Form::open(['action' => ['Admin\TermController@destroy', 'apartment'], 'method' => 'DELETE']) !!}
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('admin.common.term'): @lang('admin.common.delete')</h4>
                    </div>
                    <div class="modal-body">
                        <p>@lang('admin.common.Are you sure term') - <b id="deleteTermName"></b>?</p>
                        {!! Form::hidden('key', null, ['id' => 'term-id']) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.common.cancel')</button>
                        <button type="submit" class="btn btn-primary">@lang('admin.common.delete')</button>
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="//cdn.datatables.net/rowreorder/1.1.2/js/dataTables.rowReorder.min.js"></script>
	<script type="text/javascript">
		$('.table.term').on('click', '.btn', function(event) {
			if ($(this).hasClass('btn-primary')) $('#modal-term').modal('show');
			else if ($(this).hasClass('btn-dander'))	$(this).parents('tr').fadeOut();
		});

        $("#deleteModal").on('show.bs.modal', function(e){
            var invoker = $(e.relatedTarget),
                key = invoker.data("key"),
                name = invoker.data('name');
            $(this).find("#term-id").val(key);
            $(this).find("#deleteTermName").text(name);
        });

        $('#modal-term-edit').on('show.bs.modal', function (e) {
			var $invoker = $(e.relatedTarget);
			var mode = $invoker.data("mode");
			$('#modal-term-edit .modal-dialog').html("@include('partials.css3-loading')");
			if (mode == "edit") {
				$.get('{{ action('Admin\TermController@edit', ['type' => 'apartment', 'id' => 'id']) }}'.replace('id', $invoker.data('key')), function(data){
					$('#modal-term-edit .modal-dialog').html(data);
				});
			} else {
				$.get('{{ action('Admin\TermController@create', 'apartment') }}', function(data){
					$('#modal-term-edit .modal-dialog').html(data);
				});
			}
		});
	</script>
@endsection
