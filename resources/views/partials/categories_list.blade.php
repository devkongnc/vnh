<div class="row">
    @foreach($categories as $index => $category)
    <div class="col-md-6 col-sm-6">
        <a href="{{ URL::action('CategoryController@show', $category->permalink) }}">
        <div class="feature-blk">
            <img src="{{ $category->post_thumbnail }}" alt="">
            <div class="desc">
            <h3>&nbsp;{{ $category->title }}</h3>
            <p>
                {{ str_limit(strip_tags($category->description), 230) }}
            </p>
            </div>
        </div>
        </a>
    </div>
    @endforeach
</div>

{!! with(new App\VietnamHouse\Pagination\PaginationPresenter($categories))->render() !!}
