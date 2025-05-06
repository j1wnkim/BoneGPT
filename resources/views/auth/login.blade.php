@extends('layout')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1>Login</h1>
                        <form method="POST" action="{{ route('login.authenticate') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required autofocus>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            {{-- <div class="form-group form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div> --}}
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        
                    </div>
                </div>

                <p class="small text-center">
                    <a href="{{ route('register') }}">Register a New Account</a>
                    &bull;
                    <a href="{{ route('forgot-password') }}">Forgot Password</a>
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                <div class="text-center mt-3">
                    <a href="{{ route('cas.login') }}" class="btn btn-primary">UConn Login</a>
                </div>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection