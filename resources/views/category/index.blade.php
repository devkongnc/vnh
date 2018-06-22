@extends('layout.base')

@section('content')

<div class="content-l">
    <div class="img-breadcrumb" style="background:url({{ asset('images/new-layout/img-rental.jpg') }}">
        <div class="txt-breadcrumb">
            <h1>FEATURE</h1>
            <h4>オフィス特集</h4>
        </div>
    </div>
    {{-- call list category --}}
    @include('partials.categories_list', ['categories' => $categories])
</div>

@endsection
