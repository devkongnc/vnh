@extends('layout.base')

@section('content')
    <div class="breadcrumb-blk">
        <div class="content-l">
            {!! Breadcrumbs::render('category',$category) !!}
        </div>
    </div>
    <div class="content-l">
        <div class="row">
            <div class="col-md-12">
                <div class="feature-blk category-single">
                    <img src="{{ $category->post_thumbnail }}" alt="{{ $category->title }}" />
                    <div class="desc">
                        <h3>{{ $category->title }}&nbsp;</h3>
                        <div>{!! $category->description !!}</div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.three-grid', ['items' => $results])

        {{-- call paginate --}}
        {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($results))->render() !!}
    </div> {{-- end content-l --}}

@endsection
