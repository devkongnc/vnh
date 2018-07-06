@extends('layout.base')

@section('content')
    {{--show content page start--}}
    <div class="breadcrumb-blk">
        @if (str_replace('/', '-', $page->permalink) == 'company-contact')
            <div class="content-s">
                @else
                    <div class="content-l">
                        @endif
                        {!! Breadcrumbs::render('about-page', $page) !!}
                    </div>
            </div>

            <div class="content-s">
                <div class="bg-white content-page">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="title-m center mrb-30">Contact Us　</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            Please fill out the form below. <img src="/images/new-layout/icon-require.png" > Required item
                            @include('partials.contact_form', ['prefix' => 'contact'])
                        </div>
                    </div>
                </div>
            </div>
    {{--show content page end--}}
@endsection
