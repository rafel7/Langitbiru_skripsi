@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div style="display: flex; justify-content: center; padding: 40px;">
    <div style="width: 100%; max-width: 960px; display: flex; flex-direction: column; align-items: center; gap: 40px;">
        {{-- Deskripsi --}}
        <div style="width: 100%; padding: 24px; border: 1px solid #ccc; border-radius: 12px; background-color: #fafafa; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 10px; text-align: center;">Selamat Datang di Platform </br>
                Belajar Polusi Udara!</h3>
            <p style="text-align: center;">
                Di sini kamu bisa belajar sambil bermain, seru banget lho!
            </p>
            <p style="text-align: center; margin: 0;">
                📜Yuk, mulai dengan mengerjakan Pretest dulu buat ngecek seberapa paham kamu soal polusi udara.
                </br>
                🎮Setelah itu, kamu bisa langsung main game seru seperti Cari Kata dan Teka-Teki Silang!
                </br>
                📊Kalau udah selesai main, jangan lupa kerjain Posttest ya, biar tahu seberapa jauh kamu berkembang.
                </br>
                ⭐Terakhir, kamu bisa cetak sertifikat di halaman dashboard. Keren kan?
        		</br>
        		</br>
                Sebelum mulai, kamu bisa banget lihat halaman nilai untuk lihat temen-temen yang udah ngerjaiin!!
            </p>
        </div>

        {{-- Bagian Pretest & Posttest --}}
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; width: 100%;">

            {{-- Kartu Pretest --}}
            @php
            $pretestSelesai = $statusTugas?->pretest == 1;
            $posttestSelesai = $statusTugas?->posttest == 1;
            @endphp

            <div style="flex: 1 1 300px; max-width: 400px; padding: 24px; border: 1px solid #ccc; border-radius: 12px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <div class="d-flex justify-content-center align-items-center" style="padding: 20px;">
                    <img src="{{ asset('images/mulai.png') }}" alt="Mulai" width="100" height="100">
                </div>

                <p style="margin-bottom: 16px;">
                    @if ($posttestSelesai)
                    Kamu sudah selesai, silahkan cetak sertifikat di samping
                    @elseif ($pretestSelesai)
                    Silahkan lanjutkan ke checkpoint terakhir
                    @else
                    Mulai dengan mengerjakan PreTest untuk mengukur kemampuan awal
                    @endif
                </p>

                <a href="{{ route('pretest.form') }}"
                    @if ($pretestSelesai || $posttestSelesai) class="btn btn-secondary disabled" @else style="background-color: #1e90ff; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none;" @endif>
                    @if ($pretestSelesai || $posttestSelesai)
                    Selesai
                    @else
                    Mulai
                    @endif
                </a>
            </div>


            {{-- Kartu Sertifikat --}}
            <div style="flex: 1 1 300px; max-width: 400px; padding: 24px; border: 1px solid #ccc; border-radius: 12px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <div class="d-flex justify-content-center align-items-center; padding: 20px;">
                    <img src="{{ asset('images/sertifikat.png') }}" alt="sertifikat" width="130" height="130">
                </div>
                <h3 style="margin-bottom: 10px;"></h3>
                <p style="margin-bottom: 16px;">Cetak sertifikat sebagai bukti telah menyelesaikan pembelajaran.</p>
                @if ($statusTugas?->posttest == 1)
                <a href="{{ route('sertifikat.download') }}" style="background-color: #1e90ff; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none;">Cetak Sertifikat</a>
                @endif
            </div>

        </div>


    </div>
</div>
@endsection