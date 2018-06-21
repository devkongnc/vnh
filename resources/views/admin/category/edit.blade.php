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

@section('view-page')
    <a class="btn btn-info view-page" href="{{ action('CategoryController@show', $category->permalink) }}" target="_blank">@lang('admin.common.view')</a>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('admin.entity.category')： @lang('admin.common.edit')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
                <li><a href="{{ action('Admin\CategoryController@index') }}">@lang('admin.entity.category')</a></li>
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
                            {!! Form::open(['action' => ['Admin\CategoryController@update', $category->id], 'method' => 'PUT', 'id' => 'create-highlight', 'class' => 'form-horizontal']) !!}
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

@push('scripts')
    <script type="text/javascript">
        var _TOKEN = $('input[name="_token"]').val();
        $('.btn-danger').click(function(event) {
            event.preventDefault();
            if (!confirm('{{ trans('admin.common.Are you sure?') }}')) return;
            $('<form>', {
                'action': '{{ action('Admin\CategoryController@destroy', $category->id) }}',
                'method': 'POST',
                'html': '<input name="_method" value="DELETE" type="hidden"><input name="_token" value="' + _TOKEN + '" type="hidden">'
            }).appendTo('body').submit();
        });
    </script>
@endpush
