@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 shadow rounded p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4">Daftar Akun</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NIM --}}
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input id="nim" type="text"
                        class="form-control @error('nim') is-invalid @enderror"
                        name="nim" value="{{ old('nim') }}" required>
                    @error('nim')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-4">
                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                    <input id="password-confirm" type="password"
                        class="form-control"
                        name="password_confirmation" required>
                </div>

                {{-- Tombol --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a class="btn btn-outline-secondary" href="{{ route('login') }}">Sudah punya akun? Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection