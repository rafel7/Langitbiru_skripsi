@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center ">
        <div class="col-md-10 shadow rounded overflow-hidden" style="display: flex; min-height: 550px;">

            {{-- Bagian Kiri (Abu-abu Muda) --}}
            <div class="d-none d-md-flex flex-column justify-content-center align-items-center bg-light"
                style="flex: 1; padding: 0; margin: 0;">
                <div style="width: 100%; padding: 40px;">
                    <h2 class="text-dark text-center mb-3">Selamat Datang!</h2>
                    <p class="text-center text-secondary">Melalui situs ini, kamu akan belajar tentang polusi udara mulai dari mengapa polusi udara itu penting untuk dipahami, hingga seberapa berbahaya dampaknya bagi kesehatan dan lingkungan</p>
                </div>
            </div>


            {{-- Bagian Kanan (Form Login) --}}
            <div class="p-4" style="flex: 1;">
                <h3 class="text-center mb-4">Login</h3>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- NIM --}}
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input id="nim" type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" required autofocus>
                        @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a class="btn btn-outline-secondary" href="{{ route('register') }}">Belum punya akun? Register</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection