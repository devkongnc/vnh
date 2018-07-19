@extends('layout.base')

@section('content')
    {{--show content page start--}}
    <div class="breadcrumb-blk">
        <div class="content-{{ (str_replace('/', '-', $page->permalink) == 'company-contact')  ? 's' : 'l' }}">
            {!! Breadcrumbs::render('about-page', $page) !!}
        </div>
    </div>

    <div class="content-s">
        <div class="bg-white content-page">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2 class="title-border">@lang('entity.page.contact.title')</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    @lang('entity.page.contact.required_description') <img src="/images/new-layout/icon-require.png" > @lang('entity.page.contact.required')
                    @include('partials.contact_form', ['prefix' => 'contact'])
                </div>
            </div>
        </div>
    </div>
@endsection
