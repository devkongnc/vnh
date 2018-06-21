<ul class="review-list list row">
    @foreach($reviews as $review)
        <li class="review-list-item" style="background-image: url('{{ $review->feature_image }}');" data-categories="{{ json_encode($review->categories) }}">
            <a class="permalink" href="{{ $review->url }}"></a>
            <div class="gray-overlay"></div>
            <a class="title" href="{{ $review->url }}">{{ $review->title }}</a>
            <p class="time">{{ $review->timestampdot }}</p>
            <div class="icons-wrapper">
                {!! $review->icons !!}
            </div>
        </li>
    @endforeach
</ul>
<div class="pagination-wrapper">
    {!! with(new App\VietnamHouse\Pagination\PaginationPresenter($reviews))->render() !!}
</div>
