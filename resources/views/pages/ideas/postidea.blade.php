@extends('layout')

@section('content')
<div class="container my-3">
    <h2>Post Your Idea</h2>

    <!-- Menampilkan alert -->
    @include('components.alert')

    <form method="POST" action="/postidea">
        @csrf
        <div class="form-group mb-3">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group mb-3">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Idea</button>
    </form>
</div>
@endsection
