@extends('layouts.app')

@section('title', 'Video Pembelajaran 1')

@section('content')
<div class="w-100">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ url('/pembelajaran/video1') }}" class="btn btn-primary" style="margin-right: 20px;">Back</a>
        <a href="{{ url('/slides/materi1') }}" id="selesaiBtn" class="btn btn-primary" style="margin-right: 20px;">Next</a>
    </div>

    <h2 class="mb-4 text-center">Video Pembelajaran: 2</h2>

    <div class="video-container mb-4 position-relative">
        <iframe id="videoFrame" src="https://www.youtube.com/embed/HTJ7lrYppzk?enablejsapi=1"
            frameborder="0"
            allowfullscreen
            title="Video Pembelajaran"
            style="width: 100%; height: 60vh; border-radius: 8px;">
        </iframe>

        <!-- Timer -->
        <div id="timerBox" class="position-absolute top-0 end-0 m-3 bg-dark text-white px-3 py-2 rounded" style="font-size: 1.2rem; display: none;">
            02:40
        </div>
    </div>


</div>

<!-- Timer Script 
<script>
    let timeLeft = 160; // 2 menit 40 detik
    let timerInterval;
    let timerBox = document.getElementById('timerBox');

    function formatTime(seconds) {
        const m = String(Math.floor(seconds / 60)).padStart(2, '0');
        const s = String(seconds % 60).padStart(2, '0');
        return `${m}:${s}`;
    }

    function startTimer() {
        if (timerInterval) return; // mencegah timer double
        timerBox.style.display = 'block';
        timerBox.textContent = formatTime(timeLeft);

        timerInterval = setInterval(() => {
            timeLeft--;
            timerBox.textContent = formatTime(timeLeft);

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerBox.textContent = "Selesai!";
            }
        }, 1000);
    }

    // Integrasi dengan YouTube iframe API
    var player;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('videoFrame', {
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
            startTimer();
        }
    }

    // Load YouTube API
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    document.getElementById('selesaiBtn').addEventListener('click', function() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        const formattedTime = `00:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`; // Jam:Menit:Detik


        fetch("{{ route('simpan.waktu.video') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    waktu_sisa: formattedTime
                })
            })
            .then(response => response.json())
            .then(data => {
                alert("Waktu berhasil disimpan!");
                // redirect jika perlu
                // window.location.href = "{{ url('/slides/materi1') }}";
            });
    });
</script>-->
@endsection