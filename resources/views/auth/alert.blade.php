@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ol>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ol>
    </div>
@endif
