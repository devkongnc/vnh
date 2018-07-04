@extends('admin.layout.base')

@section('styles')
    <style type="text/css">
        .media {
            display: table;
        }
        .media-body {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ $contact->email }}</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
                <li><a href="{{ action('Admin\ContactController@index') }}">@lang('admin.entity.contact')</a></li>
                <li class="active">{{ $contact->email }}</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <section class="col-lg-12">
                    <div class="box box-solid">
                        <div class="box-body nopadding">
                            <form id="form-contact" action="{{ action('Admin\ContactController@destroy', $contact->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">@lang('admin.user.fullname')</label>
                                    <div class="col-sm-4">
                                        <div class="form-control">{{ $contact->name }}</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 control-label">@lang('admin.user.phone')</label>
                                    <div class="col-sm-4">
                                        <div class="form-control">{{ $contact->phone }}</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">@lang('admin.user.email')</label>
                                    <div class="col-sm-4">
                                        <div class="form-control">{{ $contact->email }}</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="created_at" class="col-sm-2 control-label">@lang('admin.common.created at')</label>
                                    <div class="col-sm-4">
                                        <div class="form-control">{{ $contact->created_at }}</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="message" class="col-sm-2 control-label">@lang('admin.contact.message')</label>
                                    <div class="col-sm-10">
                                        <textarea id="message" class="form-control" rows="4">{{ $contact->message }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-danger btn-action btn-delete">@lang('admin.common.delete')</button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">@lang('admin.entity.estate')</label>
                                </div>
                                @foreach($estates as $estate)
                                <div class="media">
                                    <a class="pull-left" href="{{ action('RealEstateController@show', $estate->product_id) }}" target="_blank">
                                        <img class="media-object" src="{{ asset($estate->post_thumbnail) }}" width="175" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ $estate->title }}</h4>
                                        <!-- <p>Text goes here...</p> -->
                                    </div>
                                </div>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#form-contact').submit(function(event) {
            if (confirm('{{ trans('admin.common.Are you sure?') }}')) return true;
            return false;
        });
    </script>
@endsection
