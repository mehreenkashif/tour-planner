
@extends('layouts.app')

@section('title', isset($user) ? 'Edit User' : 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4 text-center">
                    {{ isset($user) ? 'Edit User' : 'Register' }}
                </h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div  id="success-alert" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST"
                    action="{{ isset($user)
                  ? route('users.update', $user->id)
                  : (auth()->check() && auth()->user()->role === 'admin'
                      ? route('admin.users.store')
                      : route('register')) }}">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $user->name ?? '') }}"
                               required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email ?? '') }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">
                            Password
                            @if(isset($user)) <small>(Leave blank to keep current)</small> @endif
                        </label>

                        <div class="input-group">
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   @if(!isset($user)) required @endif>

                            <span class="input-group-text" style="cursor: pointer" onclick="togglePasswordVisibility()">
                                <i id="eyeIcon" class="bi bi-eye"></i>
                            </span>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation"
                               @if(!isset($user)) required @endif>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Register as</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">Select role</option>
                            <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="tour_planner" {{ old('role', $user->role ?? '') == 'tour_planner' ? 'selected' : '' }}>Tour Planner</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ isset($user) ? 'Update User' : 'Register' }}
                    </button>
                </form>

                @if(!isset($user) && (!auth()->check() || auth()->user()->role !== 'admin'))
                <hr>
                <p class="text-center mb-0">
                    Already have an account?
                    <a href="{{ route('login') }}">Login here</a>
                </p>
            @endif

            </div>
        </div>
    </div>
</div>
@endsection


<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("bi-eye");
            eyeIcon.classList.add("bi-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("bi-eye-slash");
            eyeIcon.classList.add("bi-eye");
        }
    }
</script>
