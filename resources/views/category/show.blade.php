@extends('layout.base')

@section('content')
    <div class="content-l">
        <div class="row">
            <div class="col-md-12">
                <div class="feature-blk category-single">
                    <img src="{{ $category->post_thumbnail }}" alt="{{ $category->title }}"/ >
                    <div class="desc">
                        <h3>{{ $category->title }}</h3>
                        <p>{!! $category->description !!}</p>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.three-grid', ['items' => $results])
        {{-- <div class="pagination-wrapper">
            {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($results))->render() !!}
        </div> --}}

        {{-- call paginate --}}
        {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($results))->render() !!}

    </div> {{-- end content-l --}}

@endsection
