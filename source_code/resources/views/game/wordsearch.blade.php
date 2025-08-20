@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center flex-column mt-5">

    <h2>Game Cari Kata!</h2>
    <div id="textTimer">
        </br>
        <h3>Game Cari Kata</h3>
        <li>klik tombol "mulai" pada halaman saat ini untuk memulai game cari kata</li>
        <li>Cari kata dari pertanyaan di bawah</li>
        <li>Kata bisa tersembunyi secara mendatar,menurun, atau diagonal</li>
        <li>Klik dan drag kata jika kamu menemukannya</li>
        <li>Jawaban benar akan dihightlight dan muncul pada kolom jawaban</li>
        <li>Waktu 2 menit</li>
        <li>Klik "Submit Nilai" jika selesai dan melanjutkan game selanjutnya</li>

        </br>
        <h3>Game Teka Teki Silang</h3>
        <li>Cari jawaban dari pertanyaan di bawah</li>
        <li>Jawaban benar akan dihighlight warna hijau pada gambar</li>
        <li>Jawaban salah atau belum terisi akan dihightlight warna merah</li>
        <li>Tekan "enter" atau klik "cek jawaban" untuk mengecek jawaban yang diisi</li>
        <li>Waktu 2 menit</li>
        <li>Klik "Selesai" jika selesai dan melanjutkan game selanjutnya</li>

        </br>

    </div>

    <button id="startButton" class="btn btn-primary mb-4">Mulai</button>

    <div id="gameArea" style="display:none;">
        <div id="timer" class="h4 text-center mb-3">Sisa Waktu: 2:00</div>
        <p class="text-center">Cari kata berikut:</p>
        <!-- <ul id="word-list" class="text-center" style="list-style:none; padding:0; ">
            <li id="word-AQI"><strong>AQI</strong></li>
            <li id="word-PM25"><strong>PM2,5</strong></li>
            <li id="word-ASMA"><strong>ASMA</strong></li>
            <li id="word-HUJAN"><strong>HUJAN</strong></li>
            <li id="word-ASAP"><strong>ASAP</strong></li>
        </ul> -->

        <div id="grid">
            @php
            $letters = [
            ['R','A','H','Q','E','5','L'],
            ['B','S','2','U','D','M','O'],
            ['U','A','C','P','J','S','T'],
            ['A','P','M','2','5','A','A'],
            ['1','0','K','H','M','Q','N'],
            ['G','N','I','S','P','I','C'],
            ['H','B','A','O','2','U','B'],
            ];
            @endphp

            @foreach($letters as $row => $line)
            @foreach($line as $col => $letter)
            <div data-row="{{ $row }}" data-col="{{ $col }}"
                class="cell border m-1 p-2"
                style="width:45px; height:45px; display:flex; align-items:center; justify-content:center;">
                {{ $letter }}
            </div>
            @endforeach
            @endforeach
        </div>
        <div class="mt-4 w-100">

            <div class="d-flex mb-3 border p-3 align-items-center">
                <div class="w-75"><strong>1. Nama indeks yang digunakan untuk mengukur kualitas udara</strong></div>
                <input type="text" id="a1" class="form-control w-25 ms-3" placeholder="Jawaban" readonly>
            </div>

            <div class="d-flex mb-3 border p-3 align-items-center">
                <div class="w-75"><strong>2. Senyawa yang partikelnya kecil dan sulit disaring hdiung</strong></div>
                <input type="text" id="a2" class="form-control w-25 ms-3" placeholder="Jawaban" readonly>
            </div>

            <div class="d-flex mb-3 border p-3 align-items-center">
                <div class="w-75"><strong>3. Faktor utama terjadi polusi udara</strong></div>
                <input type="text" id="a3" class="form-control w-25 ms-3" placeholder="Jawaban" readonly>
            </div>

            <div class="d-flex mb-3 border p-3 align-items-center">
                <div class="w-75"><strong>4. Penyakit yang disebabkan oleh polusi udara</strong></div>
                <input type="text" id="a4" class="form-control w-25 ms-3" placeholder="Jawaban" readonly>
            </div>

            <div class="d-flex mb-3 border p-3 align-items-center">
                <div class="w-75"><strong>5. Hal yang dapat mengurangi polusi udara</strong></div>
                <input type="text" id="a5" class="form-control w-25 ms-3" placeholder="Jawaban" readonly>
            </div>
        </div>



        <div class="text-center mt-4">
            <button id="submitScore" class="btn btn-success ">Submit Nilai</button>

        </div>
        <form method="POST" id="scoreForm" action="{{ route('game.wordsearch.submit') }}">
            @csrf
            <input type="hidden" name="nilai" id="nilaiInput" value="0">
            <input type="hidden" name="waktu_game_1" id="waktuInput" value="00:00:00">
        </form>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const startButton = document.getElementById('startButton');
        const gameArea = document.getElementById('gameArea');
        const timerDisplay = document.getElementById('timer');

        let selectedCells = [];
        let foundWords = [];
        const targetWords = ["AQI", "HUJAN", "PM25", "ASAP", "ASMA"];
        const cells = document.querySelectorAll('.cell');

        let countdown; // untuk clearInterval
        let remainingTime = 120; // 2 menit

        startButton.addEventListener('click', function() {
            gameArea.style.display = 'block';
            startButton.style.display = 'none';
            textTimer.style.display = 'none';
            startTimer(); // mulai hitung mundur
        });

        function startTimer() {
            updateTimerDisplay();
            countdown = setInterval(() => {
                remainingTime--;
                updateTimerDisplay();

                if (remainingTime <= 0) {
                    clearInterval(countdown);
                    alert('⏰ Waktu Habis!');
                    updateScore();
                    submitScoreWithTime(); // submit otomatis jika waktu habis
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            let minutes = Math.floor(remainingTime / 60);
            let seconds = remainingTime % 60;
            timerDisplay.textContent = `Sisa Waktu: ${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
        }

        if (cells.length === 0) {
            console.error('Elemen .cell tidak ditemukan!');
            return;
        }

        cells.forEach(cell => {

            cell.addEventListener('mousedown', e => {
                clearSelection();
                selectedCells = [e.target];
                e.target.classList.add('selected');
            });

            cell.addEventListener('mouseover', e => {
                if (e.buttons === 1) {
                    if (!selectedCells.includes(e.target)) {
                        selectedCells.push(e.target);
                        e.target.classList.add('selected');
                    }
                }
            });

            cell.addEventListener('mouseup', () => {
                const word = selectedCells.map(el => el.textContent.trim()).join('').toUpperCase();

                if (targetWords.includes(word) && !foundWords.includes(word)) {
                    foundWords.push(word);
                    markWordAsFound(word);
                    tampilkanJawabanKeInput(word); 
                    updateScore();
                }

                clearSelection();
            });

            cell.addEventListener('click', function() {
                console.log('Cell diklik:', cell.textContent.trim());
            });
        });

        document.getElementById('submitScore').addEventListener('click', function() {
            clearInterval(countdown); // stop timer biar gak submit 2x
            updateScore(); // pastikan nilai terbaru
            submitScoreWithTime(); // submit manual dengan waktu yang tersisa
        });

        function updateScore() {
            let nilai = foundWords.length * 40;
            document.getElementById('nilaiInput').value = nilai;

            if (nilai === 100) {
                document.getElementById('submitScore').style.display = 'inline-block';
            }
        }

        function markWordAsFound(word) {
            const element = document.getElementById('word-' + word.toUpperCase());
            if (element) {
                element.classList.add('found');
            }
        }

        function clearSelection() {
            selectedCells.forEach(cell => cell.classList.remove('selected'));
            selectedCells = [];
        }

        function submitScoreWithTime() {
            console.log("➡️ submitScoreWithTime dipanggil");

            let minutes = Math.floor(remainingTime / 60);
            let seconds = remainingTime % 60;

            let formattedTime = `00:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById('waktuInput').value = formattedTime;

            document.getElementById('scoreForm').submit();
        }

        function markWordAsFound(word) {
            const element = document.getElementById('word-' + word.toUpperCase());
            if (element) {
                element.classList.add('found');
            }

            // Ambil huruf dari kata yang ditemukan
            selectedCells.forEach(cell => {
                cell.classList.add('permanent');
            });
        };

        function tampilkanJawabanKeInput(word) {
            const mapping = {
                "AQI": "a1",
                "PM25": "a2",
                "ASAP": "a3",
                "ASMA": "a4",
                "HUJAN": "a5"
            };

            const key = mapping[word.toUpperCase()];
            if (key) {
                const input = document.getElementById(key);
                if (input) {
                    input.value = word;
                }
            }
        }


    });
</script>

<style>
    .cell {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .cell.selected {
        background-color: yellow;
        font-weight: bold;
        user-select: none;
        /* biar gak bisa di-copas */
    }

    .found {
        text-decoration: line-through;
        color: green;
    }

    /* Warna untuk kata yang ditemukan */
    .cell.permanent {
        background-color: #d4edda;
        /* warna hijau muda */
        font-weight: bold;
        color: black;
    }

    #grid {
        display: grid;
        grid-template-columns: repeat(7, 45px);
        /* 7 kolom, lebar 45px per kotak */
        gap: 8px;
        /* spasi antar kotak */
        justify-content: center;
    }
</style>
@endsection