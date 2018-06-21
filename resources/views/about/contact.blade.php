@extends('about.base')

@section('about-content')
    <article class="contact page-content">
        {!! Breadcrumbs::render('about-page', $page) !!}
        <h1>{{ $page->title }}</h1>
        <section class="wrap-content-page">
            <div class="box-hotline">
                <div class="text-contact"><span class="icon-phone"></span> @lang('entity.page.contact.contact by phone.title')</div>
                <div class="office">@lang('entity.page.contact.contact by phone.office') <span>@lang('entity.page.contact.contact by phone.office_number')</span></div>
                @if (App::isLocale('ja'))
                    <a href="tel:@lang('entity.page.contact.contact by phone.number')" class="live">@lang('entity.page.contact.contact by phone.japanese') <span>@lang('entity.page.contact.contact by phone.number')</span></a>
                @endif
            </div>
            @include('partials.contact_form', ['prefix' => 'contact'])
        </section>
    </article>
@endsection
