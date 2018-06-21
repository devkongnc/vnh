    @extends('layout.base')

@section('content')
    <article class="row" id="content">
        {!! Breadcrumbs::render('review', $review) !!}
        <div class="single-review row">
            <div class="left-section col-sm-3">
                <div class="review-stick">
                    <div class="navsingle-review">
                        <a href="{{ action('ReviewController@index') }}"><img src="{{ asset('images/review_logo.svg') }}" width="177" /></a>
                        <p class="guarantee text-center">@lang('entity.review.description')</p>
                        <a href="{{ action('ReviewController@index') }}" class="border-button btn-block text-center"><b>@lang('entity.review.top')</b></a>
                        <form action="{{ action('ReviewController@search') }}" method="GET" class="fucnt-search">
                            <input name="title" value="" required=""> <button type="submit"><span class="icon-search"></span></button>
                        </form>
                        <div class="note {{ LaravelLocalization::getCurrentLocale() }}">
                        @foreach ((array) trans('admin.review.categories') as $index => $value)
                            <a href="{{ action('ReviewController@category', [config('override.category.' . $index)]) }}"><i class="icon-{{ trans('admin.review.categories icon.' . $index) }}" aria-hidden="true"></i> {{ $value }}</a>
                        @endforeach
                        </div>
                        @if (!empty($review->user))
                        <div class="writer-information center-block">
                            <h3>WRITER</h3>
                            <img src="/images/favicon.png" />
                            <p class="writer-name">Vietnamhouse</p>
                        </div>
                        @endif
                        <p class="text-center">
                            <a class="review-social" onclick="shareSocial('facebook')"><i class="icon icon-facebook"><span class="path1"></span><span class="path2"></i></a>
                            <a class="review-social" onclick="shareSocial('twitter')"><i class="icon icon-twitter"></i></a>
                            <a class="review-social"><i class="icon icon-line"></i></a>
                            <a class="review-social" onclick="shareSocial('google')"><i class="icon icon-google"></i></a>
                        </p>
                    </div>
                </div>
            </div>
            <section class="right-section col-sm-9">
                <div class="row">
                    <address class="review-time col-sm-2 col-sm-push-10 text-right">{{ $review->custom_created_at }}</address>
                    <h1 class="col-sm-10 col-sm-pull-2"> {{ $review->title }}</h1>
                </div>
                <div class="review-content">
                    {!! $review->description !!}
                </div>
                <div class="review-pagination">
                    @if ($previous)
                        <a class="previous" href="{{ $previous->url }}">
                            <p>{{ $previous->title }}</p>
                        </a>
                    @endif
                    @if ($next)
                        <a class="next" href="{{ $next->url }}">
                            <p>{{ $next->title }}</p>
                        </a>
                    @endif
                </div>
                <a href="{{ action('ReviewController@index') }}" class="visible-xs btn border-button btn-block">@lang('entity.review.top')</a>
            </section>
        </div>
    </article>
@endsection

@section('edit')
    <li><a href="{{ action('Admin\ReviewController@edit', $review->id) }}">@lang('front.edit page')</a></li>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            /*===== Menu left page review ======*/
            /*if($(window).width()>=992){
                topnavreview = $(".navsingle-review").offset().top;
                widthnavreview = $(".navsingle-review").css('width');
                hnavreview = $(".navsingle-review").css('height');
                heighthead = $('header').height();
                topfooter = $('footer').offset().top;
                heightfoot = $('footer').css('height');
            }*/
        });
    </script>
@endsection
