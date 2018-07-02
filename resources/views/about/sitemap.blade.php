@extends('layout.base')

@section('content')
    <div class="breadcrumb-blk">
        <div class="content-s">
            {!! Breadcrumbs::render('sitemap') !!}
        </div>
    </div>
    <article class="sitemap about">
        <div class="content-s">
            <div class="bg-white content-page">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title-m center mrb-30">@lang('menu.sitemap')</h2>
                    </div>
                </div>

                <?php
                $sitemap_structure = Config::get('sitemap.new_layout');
                ?>
                <div class="row">
                    @foreach ($sitemap_structure as $group)
                        <div class="col-md-4 col-sm-4">
                            <ul class="menu-list">
                                @foreach ($group as $item)
                                    @if ($item === 'home')
                                        <li><a href="{{ route('home') }}">@lang('menu.home')</a></li>
                                    @elseif(isset($pages_by_id[$item]))
                                        <li>
                                            <a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[$item]->permalink) }}">
                                                {{ $pages_by_id[$item]->title }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </article>
@endsection
