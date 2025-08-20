@extends('layouts.app')

@section('title', '')

@section('content')
<div style="display: flex; justify-content: center; padding: 40px;">
    <div style="display: flex; gap: 40px; width: 100%; max-width: 1000px;">

        {{-- Kiri: Dua kotak (atas & bawah) --}}
        <div style="flex: 1; display: flex; flex-direction: column; gap: 40px;">
            {{-- Kartu Nilai --}}
            <div style="flex: 1 1 300px;  padding: 24px; border: 1px solid #ccc; border-radius: 12px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 20px;">Nilai Kamu</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @php
                    $pretest = $nilaiSaya->nilai_pretest ?? '-';
                    $posttest = $nilaiSaya->nilai_posttest ?? '-';
                    $game1 = $nilaiSaya->t_nilai_game_1 ?? '-';
                    $game2 = $nilaiSaya->t_nilai_game_2 ?? '-';
                    @endphp

                    @foreach ([['Nilai PreTest', $pretest], ['Nilai PostTest', $posttest], ['Game Cari Kata', $game1], ['Game TTS', $game2]] as [$label, $value])
                    <div style="display: flex; gap: 10px;">
                        <div style="flex: 1; background: #e6f7ff; padding: 10px; border-radius: 6px; text-align: left;">
                            {{ $label }}
                        </div>
                        <div style="width: 60px; background: #f0f0f0; padding: 10px; border-radius: 6px; text-align: center;">
                            {{ $value }}
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>



            {{-- Kotak Badge --}}
            <div style="padding: 24px; border: 1px solid #ccc; border-radius: 12px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 10px;">Badge</h3>
                <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: nowrap;">
                    @php
                    use App\Models\Badge;

                    $userBadge = Badge::where('user_id', auth()->id())->first();

                    //$badge1 = 'badge-default.png';
                    $badge2 = 'badge-default.png';
                    $badge3 = 'badge-default.png';
                    $badge4 = 'badge-default.png';

                    if ($userBadge) {
                    // Badge 1 - lampu
                    //if ($userBadge->badge1 === 0) $badge1 = '0.png';
                    //elseif ($userBadge->badge1 === 1) $badge1 = 'lampu1.png';
                    //elseif ($userBadge->badge1 === 2) $badge1 = 'lampu2.png';
                    //elseif ($userBadge->badge1 === 3) $badge1 = 'lampu3.png';

                    // Badge 2 - trophy
                    if ($userBadge->badge2 === 0) $badge2 = '0.png';
                    elseif ($userBadge->badge2 === 1) $badge2 = 'trophy1.png';
                    elseif ($userBadge->badge2 === 2) $badge2 = 'trophy2.png';
                    elseif ($userBadge->badge2 === 3) $badge2 = 'trophy3.png';

                    // Badge 3 - petir
                    if ($userBadge->badge3 === 0) $badge3 = '0.png';
                    elseif ($userBadge->badge3 === 1) $badge3 = 'petir1.png';
                    elseif ($userBadge->badge3 === 2) $badge3 = 'petir2.png';
                    elseif ($userBadge->badge3 === 3) $badge3 = 'petir3.png';

                    // Badge 4 - medal
                    if ($userBadge->badge4 === 0) $badge4 = '0.png';
                    elseif ($userBadge->badge4 === 1) $badge4 = 'medal1.png';
                    elseif ($userBadge->badge4 === 2) $badge4 = 'medal2.png';
                    elseif ($userBadge->badge4 === 3) $badge4 = 'medal3.png';
                    }

                    $badgeLabels = [ 'Game Master', 'Speedster', 'Collector'];
                    $badgeImages = [ $badge2, $badge3, $badge4];
                    @endphp


                    @foreach ($badgeImages as $i=> $badge)
                    <div style="text-align: center; width: 65px;">
                        <img src="{{ asset('images/badges/' . $badge) }}" alt="Badge {{ $i + 1 }}"
                            style="width: 100%; height: 100%; object-fit: contain;">
                        <div style="margin-top: 6px; font-size: 12px; font-weight: 600;">{{ $badgeLabels[$i] }}</div>
                    </div>
                    @endforeach

                </div>
                <details style="margin-top: 50px; text-align: left; font-size: 14px;">
                    <summary style="cursor: pointer; font-weight: 600; text-align:center;">Penjelasan Badge</summary>
                    <ul style="margin-top: 8px; padding-left: 20px;">

                        <li><strong>Game Master : Menyelesaikan semua game dengan nilai tertentu</strong><br>
                            Bronze : 120 poin untuk setiap game<br>
                            Silver : 160 poin untuk setiap game<br>
                            Gold : 200 poin untuk setiap game<br>
                        </li>
                        <li><strong>Speedster: Menyelesaikan game dengan sisa waktu tertentu</strong><br>
                            Bronze: 50% sisa waktu untuk setiap game<br>
                            Silver: 65% sisa waktu untuk setiap game<br>
                            Gold:80% sisa waktu untuk setiap game
                        </li>
                        <li><strong>Collector : Mendapatkan badge dengan jumlah tertentu</strong>
                            <br> Bronze : 2 Badge Bronze
                            <br> Silver : 2 Badge Silver
                            <br> Gold : 2 Badge Gold
                        </li>
                    </ul>
                </details>

            </div>


        </div>

        {{-- Kanan: Leaderboard --}}
        <div style="flex: 1; padding: 24px; border: 1px solid #ccc; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); overflow-y: auto; max-height: 450px;">
            <h3 style="text-align: center; margin-bottom: 16px;"> Leaderboard</h3>
            {{-- Tab Menu --}}
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ $jenis == 't_nilai_game_1' ? 'active' : '' }}"
                        href="{{ route('nilai.index', ['jenis' => 't_nilai_game_1']) }}">
                        Game 1
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $jenis == 't_nilai_game_2' ? 'active' : '' }}"
                        href="{{ route('nilai.index', ['jenis' => 't_nilai_game_2']) }}">
                        Game 2
                    </a>
                </li>
            </ul>

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 8px; border: 1px solid #ddd;">Rank</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Nama</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Skor</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($leaderboard as $index => $item)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">{{ $index + 1 }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $item->user->name ?? 'Tidak diketahui' }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">{{ $item->$jenis }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">Belum ada data leaderboard.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection