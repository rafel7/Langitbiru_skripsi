@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2>Teka-Teki Silang</h2>
    <div id="timer" class="mb-4 fs-5">Sisa Waktu: 5:00</div>

    <!-- FORM CEK JAWABAN -->
    <form method="POST" id="scoreForm" action="{{ route('game.teka-teki-silang.submit') }}">
        @csrf

        <div class="d-flex justify-content-center">
            <div id="crossword"
                style="display: grid; grid-template-columns: repeat(10, 40px); grid-template-rows: repeat(10, 40px); gap: 2px;">
                @php $filled = $filled ?? []; @endphp
                @for ($row = 1; $row <= 10; $row++)
                    @for ($col=1; $col <=10; $col++)
                    @php
                    $key="$row-$col" ;
                    $value=$filled[$key]['char'] ?? '' ;
                    $class='' ;
                    $isAnswerCell=isset($filled[$key]);

                    if ($isAnswerCell) {
                    $class=$filled[$key]['correct'] ? 'bg-success text-white' : 'bg-danger text-white' ;
                    }

                    $style="width: 100%; height: 100%; border: 1px solid #ccc;" ;
                    if (!$value && $isAnswerCell) {
                    $style .=" background-color: #cce5ff;" ;
                    } elseif (!$value) {
                    $style .=" background-color: #ddd;" ;
                    }
                    @endphp
                    <div class="d-flex justify-content-center align-items-center {{ $class }}" style="{{ $style }}">
                    {{ $value }}
            </div>
            @endfor
            @endfor
        </div>
</div>

<!-- Pertanyaan -->
<div class="text-start mx-auto mt-4" style="max-width: 600px;">
    <h5>Petunjuk & Jawaban</h5>
    <ul class="list-unstyled">
        @foreach ($questions as $no => $q)
        <li class="mb-3">
            <strong>{{ $no }} ({{ $q['direction'] }})</strong>: {{ $q['question'] }}<br>
            <input type="text" name="answers[{{ $no }}]" maxlength="{{ $q['length'] }}"
                value="{{ $answers[$no] ?? '' }}" class="form-control mt-1"
                style="max-width: 300px; text-transform: uppercase;">
        </li>
        @endforeach
    </ul>
</div>

<input type="hidden" name="waktu_game_2" id="waktuInput1" value="00:00:00">
<button type="submit" class="btn btn-success mt-3">Cek Jawaban</button>
</form>

<!-- FORM SELESAI -->
<form method="POST" action="{{ route('game.teka-teki-silang.submit2') }}">
    @csrf
    <input type="hidden" name="waktu_game_2" id="waktuInput2" value="00:00:00">
    <button type="submit" class="btn btn-primary mt-3">Selesai</button>
</form>
</div>

<script>
    const waktuAwal = "{{ $waktusisa }}";

    function parseTimeToSeconds(timeStr) {
        const [h, m, s] = timeStr.split(':').map(Number);
        return h * 3600 + m * 60 + s;
    }

    let remainingTime = parseTimeToSeconds(waktuAwal);
    const timer = document.getElementById('timer');
    const waktuInput1 = document.getElementById('waktuInput1');
    const waktuInput2 = document.getElementById('waktuInput2');

    function updateTimer() {
        const minutes = Math.floor(remainingTime / 60);
        const seconds = remainingTime % 60;
        timer.textContent = `Sisa Waktu: ${minutes}:${seconds.toString().padStart(2, '0')}`;

        const usedTime = 300 - remainingTime;
        const usedMinutes = Math.floor(usedTime / 60);
        const usedSeconds = usedTime % 60;

        const waktuFormatted = `00:${usedMinutes.toString().padStart(2, '0')}:${usedSeconds.toString().padStart(2, '0')}`;
        waktuInput1.value = waktuFormatted;
        waktuInput2.value = waktuFormatted;
    }

    updateTimer();
    const countdown = setInterval(() => {
        if (remainingTime > 0) {
            remainingTime--;
            updateTimer();
        } else {
            clearInterval(countdown);
            alert("⏰ Waktu Habis!");
            document.getElementById('scoreForm').submit();
        }
    }, 1000);
</script>
@endsection