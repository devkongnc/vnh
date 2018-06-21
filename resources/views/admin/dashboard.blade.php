@extends('admin.layout.base')

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				@lang('admin.entity.dashboard')
				<!-- <small>Control panel</small> -->
			</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li class="active">@lang('admin.entity.dashboard')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-solid">
						<div class="box-header with-border nopadding">
							<h3 class="box-title">@lang('admin.dashboard.new contacts')</h3>
						</div>
						<div class="box-body nopadding">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>@lang('admin.user.fullname')</th>
										<th>@lang('admin.user.phone')</th>
										<th>@lang('admin.user.email')</th>
										{{-- <th>Địa chỉ</th> --}}
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
										{{-- <td>70 Lữ Gia, Chung cư Lữ Gia</td> --}}
										<td>{{ $contact->created_at }}</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="box box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">@lang('admin.dashboard.new estates')</h3>
						</div>
						<div class="box-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>ID</th>
										<th>@lang('admin.common.title')</th>
										<th>@lang('admin.apartment.price')</th>
										<th>@lang('admin.common.status')</th>
										<th>@lang('admin.common.created by')</th>
										<th>@lang('admin.common.created at')</th>
										<th>@lang('admin.common.actions')</th>
									</tr>
								</thead>
								<tbody>
								@foreach ($estates as $estate)
									<tr>
										<td></td>
										<td>{{ $estate->product_id }}</td>
										<td>{{ link_to(action('Admin\RealEstateController@edit', $estate->id), $estate->title) }}</td>
										<td>{{ $estate->price }}</td>
										<td class="status">{!! $estate->visibility !!}</td>
										<td>{{ $estate->user->name or '' }}</td>
										<td>{{ $estate->created_at }}</td>
										<td>
											{{ link_to(action('Admin\RealEstateController@edit', $estate->id), trans('admin.common.edit'), ['class' => 'btn btn-primary']) }}
											{{ link_to(action('RealEstateController@show', $estate->product_id), trans('admin.common.view'), ['class' => 'btn btn-default', 'target' => '_blank']) }}
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="box box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">@lang('admin.dashboard.new reviews')</h3>
						</div>
						<div class="box-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>@lang('admin.common.title')</th>
										<th>@lang('admin.entity.category')</th>
										<th>@lang('admin.review.visible title')</th>
										<th>@lang('admin.common.created by')</th>
										<th>@lang('admin.common.actions')</th>
									</tr>
								</thead>
								<tbody>
								@foreach($reviews as $review)
									<tr>
										<td></td>
										<td>
											{{ link_to(action('Admin\ReviewController@edit', $review->id), $review->draft ? '(' . trans('admin.review.state.draft') . ') ' . $review->title : $review->title) }}
										</td>
										<td>
											@foreach($review->categoriesName as $name)
												<span>{{ $name }}</span>
											@endforeach
										</td>
										<td class="status">{!! $review->visibility !!}</td>
										<td>{{ $review->user->name or '' }}</td>
										<td>
											{{ link_to(action('Admin\ReviewController@edit', $review->id), trans('admin.common.edit'), ['class' => 'btn btn-primary']) }}
											{{ link_to($review->url, trans('admin.common.view'), ['class' => 'btn btn-default', 'target' => '_blank']) }}
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
		    $('table').DataTable({
		    	pageLength: 10
		    });
		} );
	</script>
@endsection
