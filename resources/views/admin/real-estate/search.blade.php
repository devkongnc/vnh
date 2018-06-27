@extends('admin.layout.base')

@section('styles')
	<style type="text/css">
		hr {
			height: 2px;
			background: black;
			margin: 20px 0 40px;;
		}
		.sortable.first {
			overflow: auto;
		}
		.sortable > .item {
			margin-bottom: 20px;
		}
		.search-term {
			border: 2px solid black;
			padding: 5px 25px 5px 10px;
			background: white;
			position: relative;
			-webkit-touch-callout: none;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			cursor: default;
		}
		.sortable.first > .item > .search-term {
			cursor: move;
		}
		.search-term > .glyphicon {
			position: absolute;
			top: 8.5px;
			right: 5px;
			cursor: pointer;
		}
	</style>
@endsection

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.estate')： @lang('admin.common.search')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\RealEstateController@index') }}">@lang('admin.entity.estate')</a></li>
				<li class="active">@lang('admin.common.search')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<section class="col-lg-12">
					<div class="box box-solid">
						{!! Form::open(['action' => 'Admin\RealEstateController@search', 'method' => 'POST']) !!}
						<form action="" method="POST" class="box-body form-horizontal nopadding">
							<?php
								//dd($terms);
							?>

							@include('partials.validations')
							<div class="sortable first row">
								@if (!empty($selected) && count($selected))
								@foreach($selected as $key)
									<div class="item col-sm-3">
										<div class="search-term">
											{{ Form::hidden('selected[]', $key) }}
											{{ \App\Term::getLocaleValue($terms[$key]['name']) }}<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
										</div>
									</div>
								@endforeach
									@else
									<?php $selected = []; ?>
								@endif
							</div>
							<hr />
							<div class="sortable second row">
								@if (!empty($terms) && count($terms))
								@foreach($terms as $key => $term)
									@if (!in_array($key, $selected))
										<div class="item col-sm-3">
											{{ Form::hidden('not_selected[]', $key) }}
											<div class="search-term">{{ \App\Term::getLocaleValue($term['name']) }}<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
										</div>
									@endif
								@endforeach
								@endif
							</div>
							<hr />
							<button type="submit" class="btn btn-primary">@lang('admin.common.save')</button>
						</form>
						{!! Form::close() !!}
					</div>
				</section>
			</div>
		</section>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
	    $( ".sortable" ).sortable({
			items: '> .item',
			connectWith: ".sortable",
			cursor: "move"
	    });

	    $('.sortable.first').on('click', '.glyphicon', function() {
	    	if ($('.sortable.first > .item').length <= 1) return;
			$(this).parents('.item').find('input').attr('name', 'not_selected[]');
	    	$(this).attr('class', 'glyphicon glyphicon-plus').parents('.item').appendTo('.sortable.second');
	    });

	    $('.sortable.second').sortable('disable').on('click', '.glyphicon', function() {
			$(this).parents('.item').find('input').attr('name', 'selected[]');
	    	$(this).attr('class', 'glyphicon glyphicon-remove').parents('.item').appendTo('.sortable.first');
	    });
	</script>
@endsection
