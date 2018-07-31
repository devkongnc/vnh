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
                    @if (!empty($office))
                    <div class="office-wrap">
                        <a href="{{ $office->url }}">
                            <div class="item-left">
                                <img src="{{ img_exists($office->post_thumbnail) }}"/>
                            </div>
                            <div class="item-content">
                                <h4>{{ $office->title }}</h4>
                                <p>{{ $office->price }} {{  (!empty($office->price_max)) ?' ~ '.$office->price_max:'' }}</strong>
                                    USD / ㎡</p>
                            </div>
                        </a>
                    </div>
                        @endif
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

@section('styles')
    <style type="text/css">
        .office-wrap{
            width: 100%;
            margin-bottom: 20px;
            display: inline-block;
        }
        .item-left{
            width: 25%;
            float: left;
        }
        .item-left img{width: 100%;}
        .item-content{
            width: 75%;
            margin-left: 25%;
            padding-left: 10px;
        }
    </style>
@endsection
