<div class="pagination-wrapper">
    <a href="#"><i class="glyphicon glyphicon-chevron-left"></i></a>
    <ul>
        <?php $current = 6; $last = 35; ?>
        @for($page = 1; $page <= $last; $page++)
            @if (abs($page - $current) <= 3 || $page == 1 || $page == $last)
                <li><a href="#">{{$page}}</a></li>
            @else
                <li>...</li>
            @endif
        @endfor
    </ul>
    <a href="#"><i class="glyphicon glyphicon-chevron-right"></i></a>
</div>