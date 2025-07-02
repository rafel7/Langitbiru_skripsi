@extends('layouts.app')

@section('title', 'Posttest')

@section('content')

<div class="container my-4">
    <h1>Posttest</h1>

    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('posttest.submit') }}" method="POST">
        @csrf

        @foreach ($questions as $question)
        <div>
            <br>
            <p>{{ $loop->iteration }}. {{ $question['question'] }}</p>
            @for ($i = 1; $i <= 5; $i++)
                <label>
                <input type="radio" name="question_{{ $question['id'] }}" value="{{ $i }}" required>
                {{ $i }}
                </label>
                @endfor
        </div>
        @endforeach

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success ">Submit Jawaban</button>

        </div>
    </form>
</div>
@endsection