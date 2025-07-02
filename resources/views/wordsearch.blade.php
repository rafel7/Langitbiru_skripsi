@extends('layouts.app') <!-- Jika menggunakan layout -->

@section('content')
<div class="container mt-5 text-center">
    <h2>Word Search Game</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Grid Word Search -->
    <div class="grid mt-3">
        @foreach($grid as $row)
        @foreach($row as $letter)
        <div class="cell">{{ $letter }}</div>
        @endforeach
        @endforeach
    </div>

    <!-- Daftar Kata yang Dicari -->
    <div class="word-list">
        <h5>Kata yang harus ditemukan:</h5>
        <p>{{ implode(', ', $words) }}</p>
    </div>

    <!-- Form Input Kata -->
    <form action="{{ route('wordsearch.check') }}" method="POST" class="mt-3">
        @csrf
        <input type="text" name="word" placeholder="Masukkan kata..." class="form-control text-center" required>
        <button type="submit" class="btn btn-primary mt-2">Cek Kata</button>
    </form>
</div>
@endsection