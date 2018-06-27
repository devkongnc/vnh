@if ($breadcrumbs)
    <div class="row">
        <div class="col-md-12">
            <ul>
                @foreach ($breadcrumbs as $breadcrumb)
                    <li>
                        <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
