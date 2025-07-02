@extends('layouts.app') <!-- Jika menggunakan layout -->

@section('content')
<div class="container text-center mt-5">
    <h2>Isi Titik dalam Kalimat</h2>

    <!-- Video -->
    <div class="video-container">
        <!-- Jika pakai file video lokal -->
        <!-- <video controls>
            <source src="{{ asset('videos/game-intro.mp4') }}" type="video/mp4">
            Browser Anda tidak mendukung pemutaran video.
        </video> -->

        <!-- Jika pakai video YouTube -->
        <iframe src="https://www.youtube.com/embed/GVBeY1jSG9Y" frameborder="0" allowfullscreen></iframe>
    </div>

    <p>Masukkan kata yang hilang ke dalam kalimat, lalu cek jawaban setelah selesai!</p>

    @if(isset($score))
    <div class="alert alert-info">
        Skor kamu: <strong>{{ $score }}</strong> dari {{ count($questions) }}
    </div>
    @endif

    <form action="{{ route('filltheblank.check') }}" method="POST" class="game-container">
        @csrf
        @foreach($questions as $index => $question)
        <div class="mb-3">
            <label class="form-label">
                {{ str_replace('____', '______', $question['sentence']) }}
            </label>
            <input type="text" name="answers[{{ $index }}]" class="form-control text-center"
                value="{{ old("answers.$index") ?? ($results[$index]['user_answer'] ?? '') }}" required>

            @if(isset($results))
            @if($results[$index]['correct'])
            <p class="correct">✅ Benar!</p>
            @else
            <p class="incorrect">❌ Salah! Jawaban yang benar: <b>{{ $results[$index]['correct_answer'] }}</b></p>
            @endif
            @endif
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Cek Jawaban</button>
    </form>
</div>
@endsection