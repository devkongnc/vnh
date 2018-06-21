<div class="row">
    @foreach($categories as $index => $category)
    <div class="col-md-6 col-sm-6">
        <div class="feature-blk">
            <img src="{{ $category->post_thumbnail }}" alt="">
            <div class="desc">
            <a href="{{ URL::action('CategoryController@show', $category->permalink) }}">
                <h3>{{ $category->title }}</h3>
            </a>
            <p>
                {{ str_limit(strip_tags($category->description), 230) }}
            </p>
            </div>
        </div>
    </div>
    @endforeach
</div>

{!! with(new App\VietnamHouse\Pagination\PaginationPresenter($categories))->render() !!}
