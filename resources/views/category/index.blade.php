@extends('layout.base')

@section('content')
    <div class="breadcrumb-blk">
        <div class="content-l">
            {!! Breadcrumbs::render('categories') !!}
        </div>
    </div>
    <div class="content-l unset_overflow">
        <div class="img-breadcrumb" style="background:url({{ asset('images/new-layout/img-rental.jpg') }}">
            <div class="txt-breadcrumb">
                <h1>FEATURE</h1>
                <h4>@lang('menu.categories')</h4>
            </div>
        </div>
        {{-- call list category --}}
        @include('partials.categories_list', ['categories' => $categories])
    </div>

@endsection
