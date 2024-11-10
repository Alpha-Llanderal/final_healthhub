@extends('layouts.app')
@section('title', 'HealthHub Connect - Register')
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
                            <h2 class="fw-bold">Patient Registration</h2>
                        </div>

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                            @csrf
                            
                            <!-- First Name Input -->
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       id="firstName"
                                       class="form-control @error('firstName') is-invalid @enderror" 
                                       name="firstName" 
                                       value="{{ old('firstName') }}" 
                                       placeholder="Enter your first name" 
                                       required 
                                       autofocus>
                                <label for="firstName">First Name</label>
                                @error('firstName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name Input -->
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       id="lastName"
                                       class="form-control @error('lastName') is-invalid @enderror" 
                                       name="lastName" 
                                       value="{{ old('lastName') }}" 
                                       placeholder="Enter your last name" 
                                       required>
                                <label for="lastName">Last Name</label>
                                @error('lastName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Input -->
                            <div class="form-floating mb-3">
                                <input type="email" 
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Enter your email" 
                                       required>
                                <label for="email">Email address</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="form-floating mb-3">
                                <input type="password" 
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Enter your password" 
                                       required>
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="form-floating mb-3">
                                <input type="password" 
                                       id="password_confirmation"
                                       class="form-control" 
                                       name="password_confirmation" 
                                       placeholder="Confirm your password" 
                                       required>
                                <label for="password_confirmation">Confirm Password</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-person-plus-fill me-2"></i>Register
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    Already have an account? Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@endpush