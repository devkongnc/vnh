@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ol style="list-style: decimal">
            @foreach ($errors->all() as $index => $error)
                <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
@endif