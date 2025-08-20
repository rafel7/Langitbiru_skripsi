@extends('layouts.app')

@section('title', 'Pretest')

@section('content')

<div class="container my-4">
    <h1>Pretest</h1>

    @if(session('success'))
    <p class="text-success">{{ session('success') }}</p>
    @endif

    <form action="{{ route('pretest.submit') }}" method="POST">
        @csrf

        @foreach ($questions as $question)
        <div class="mb-4">
            <p><strong>{{ $loop->iteration }}. {{ $question['question'] }}</strong></p>

            @if ($question['type'] === 'pg')
            @foreach ($question['options'] as $key => $option)
            <div class="form-check">
                <input class="form-check-input" type="radio" name="question_{{ $question['id'] }}" value="{{ $key }}" required>
                <label class="form-check-label">
                    {{ strtoupper($key) }}. {{ $option }}
                </label>
            </div>
            @endforeach

            @elseif ($question['type'] === 'likert')
            <div class="d-flex align-items-center flex-wrap">
                <span class="me-3 text-muted" style="min-width: 150px;">Sangat Tidak Setuju</span>

                <div class="d-flex justify-content-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <label class="mx-1 text-center">
                        <input type="radio" name="question_{{ $question['id'] }}" value="{{ $i }}" required>
                        <div>{{ $i }}</div>
                        </label>
                        @endfor
                </div>

                <span class="ms-3 text-muted" style="min-width: 150px;">Sangat Setuju</span>
            </div>
            @endif
        </div>
        @endforeach



        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success">Submit Jawaban</button>
        </div>
    </form>
</div>

@endsection