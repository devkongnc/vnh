@extends('layout.base')

@section('content')
    {{--show content page start--}}
    <div class="breadcrumb-blk">
        @if (str_replace('/', '-', $page->permalink) == 'company-contact' || str_replace('/', '-', $page->permalink) == 'company-contact-tks')
            <div class="content-s">
         @else
            <div class="content-l">
         @endif
            {!! Breadcrumbs::render('about-page', $page) !!}
        </div>
    </div>

    <article class="page-{{ str_replace('/', '-', $page->permalink) }} page-{{ $page->id }} page-content">
        {!! $page->html !!}
    </article>
    {{--show content page end--}}
@endsection

{{--@section('edit')--}}
    {{--<li><a href="{{ action('Admin\PageController@edit', $page->id) }}">@lang('front.edit page')</a></li>--}}
{{--@endsection--}}

@section('scripts')
<script type="text/javascript">
    topnav = $(".about-nav").offset().top;
    widthnav = $(".about-nav").css('width');
    hnavabout = $(".about-nav").css('height');
    heighthead = $('header').height();
    topfooter = $('footer').offset().top;
    heightfoot = $('footer').css('height');
    function sticknav(){
        $('.about-nav').height($(window).height()-parseInt(heighthead));
        if($(window).scrollTop()+parseInt(heighthead) >= topnav){
            $('.navleft-stick').css('position','fixed').css('top',heighthead).css('width',widthnav);
        }else if($(window).scrollTop()+parseInt(heighthead) < topnav){
            $('.navleft-stick').css('position','relative').css('top',0);
        }
        if($(window).scrollTop()+parseInt(hnavabout)+parseInt(heighthead) >= topfooter){
            $('.navleft-stick').css('position','fixed').css('top',topfooter-$(window).scrollTop()-parseInt(hnavabout)-40);
            $('.about-nav').height(hnavabout);
        }
    }
    $(document).ready(function(){
        /*Stick menu left*/
        if($(window).width()>=992){
            sticknav();
            $(window).scroll(function(){
                sticknav();
            });
        }
        $('.span-link').click(function(event) {
            event.preventDefault();
            window.location = $(this).attr('href');
        });
    });
</script>

@endsection
