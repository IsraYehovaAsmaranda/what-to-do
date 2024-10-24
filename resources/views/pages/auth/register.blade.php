@extends('layout')

@section('title', 'Register Page')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row w-100">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    @include('components.alert')
                    <form method="POST" action="/register">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required autofocus>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required autofocus>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
