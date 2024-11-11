@extends('layouts.app')
@section('title', 'HealthHub Connect - Login')
@section('content')
<main class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Logo and Title -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/logo.png') }}" 
                                 alt="HealthHub Logo" 
                                 class="img-fluid mb-3"
                                 width="150">
                            <h2 class="fw-bold">Patient Portal Login</h2>
                        </div>

                        <!-- Success and Error Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-3">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login.attempt') }}" class="needs-validation" novalidate>
                            @csrf
                            
                            <!-- Email Input -->
                            <div class="form-floating mb-3">
                                <input type="email" 
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Enter your email" 
                                       required 
                                       autocomplete="email"
                                       autofocus>
                                <label for="email">Email address</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="form-floating mb-3">
                                <input type="password" 
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Enter your password" 
                                       required
                                       autocomplete="current-password">
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </button>
                            </div>

                            <!-- Password Reset Link -->
                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Registration Link -->
                @if (Route::has('register'))
                    <div class="text-center mt-3">
                        <p>Don't have an account? 
                            <a href="{{ route('register') }}" class="text-decoration-none">
                                Register Here
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

