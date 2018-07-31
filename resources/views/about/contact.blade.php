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

        .gr-cotnact-row input{
            padding: 6px 10px;
            height: 40px;
            line-height: 40px;
            position: relative;
        }
        .gr-cotnact-row input[type=text]:after{
            content: "\e911";
            font-family: 'icomoon' !important;
            position: absolute;
            right: 0;
            top: 0;
            width: 45px;
            height: 45px;
            line-height: 45px;
            text-align: center;
            color: #D6D6D6;
        }

        .gr-cotnact-row input:hover{
            border: 1px solid #fbb03b;
            outline-color: transparent;
            outline-style: none;
        }

        .gr-cotnact-row input, .gr-cotnact-row textarea{border: 1px solid #5d5c5c !important; border-radius: 3px !important;}
        .ctf-show-mobile{display: none}
        @media screen and (max-width: 767px){
            .ctf_hide_mobile{display: none !important}
            .ctf-show-mobile{display: block; float: left; padding-top: 5px;}
            .gr-cotnact-row input, .gr-cotnact-row textarea{margin-left: 5%; width: 83% !important;}
        }

        @media screen and (min-width: 768px){
            .gr-cotnact-row input[type=text]::placeholder,
            .gr-cotnact-row input[type=tel]::placeholder,
            .gr-cotnact-row input[type=email]::placeholder,
            .gr-cotnact-row textarea::placeholder
            {
                opacity: 0 !important;
            }
            .gr-cotnact-row input{min-width: 340px;}
        }
    </style>
@endsection
