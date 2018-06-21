@extends('layout.base')

@section('content')
    <article id="content" class="about">
        <div class="row">
            <div class="col-md-3 visible-md visible-lg">
                <div class="navleft-stick">
                    <ul class="about-nav list sub-menu-1">
                        <li class="root-node">
                            <a href="{{ route('home') }}">@lang('menu.header.top')</a>
                            {{ showMenu($page, $menu, $pages_by_id) }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
            @if (isset($isForm) and $isForm === true)
                @yield('about-content')
            @else
                <article class="page-{{ str_replace('/', '-', $page->permalink) }} page-{{ $page->id }} page-content">
                    {!! Breadcrumbs::render('about-page', $page) !!}
                    {!! $page->html !!}
                </article>
            @endif
            </div>
        </div>
    </article>
@endsection

@section('edit')
    <li><a href="{{ action('Admin\PageController@edit', $page->id) }}">@lang('front.edit page')</a></li>
@endsection

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
