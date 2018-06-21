@extends('admin.layout.base')

@section('view-page')
    <a class="btn btn-info view-page" href="{{ $review->url }}" target="_blank">@lang('admin.common.view')</a>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('admin.entity.review')： @lang('admin.common.edit')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
                <li><a href="{{ action('Admin\ReviewController@index') }}">@lang('admin.entity.review')</a></li>
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
                            {{ Form::open(['action' => ['Admin\ReviewController@update', $review->id], 'method' => 'PUT', 'files' => true, 'id' => 'create-review', 'class' => 'row']) }}
                                @include('admin.review.content')
                            {{ Form::close() }}
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
@endsection
