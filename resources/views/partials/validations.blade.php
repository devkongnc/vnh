@if (session('flash_data'))
    <div class="alert alert-{{ session('flash_data')['status'] === 'success' ? 'success' : 'danger' }}">
		<p>{!! session('flash_data')['message'] !!}</p>
    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ol>
            @foreach ($errors->all() as $index => $error)
                <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
@endif
