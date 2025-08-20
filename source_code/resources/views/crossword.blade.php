@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Teka-Teki Silang Laravel</h1>
    <div class="image-container">
        <img src="{{ asset('images/crossword.png') }}" alt="Teka-Teki Silang" class="img-fluid mb-4" style="max-width: 300px;">
    </div>
    @if(session('score'))
    <div class="alert alert-success">
        Skor Anda: <strong>{{ session('score') }}</strong>
    </div>
    @endif

    <form action="{{ route('crossword.check') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Petunjuk</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @foreach($crossword as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['petunjuk'] }}</td>
                    <td>
                        <input type="text" name="jawaban[]" class="form-control" required>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Cek Jawaban</button>
    </form>
</div>
@endsection