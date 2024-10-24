@if ($errors->any())
    <div class="alert alert-danger my-3" role="alert">
        {{ $errors->first() }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success my-3" role="alert">
        {{ session('success') }}
    </div>
@endif
