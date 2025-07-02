<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiSaya;
use App\Models\Badge;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    // Fungsi untuk menampilkan halaman nilai
    public function index(Request $request)
    {
        if ($request->session()) {
            $userId = Auth::id();

            // Ambil nilai milik user yang sedang login
            $nilaiSaya = NilaiSaya::where('user_id', $userId)->first();


            if ($nilaiSaya) {
                $game1 = $nilaiSaya->nilai_game_1 ?? 0;
                $game2 = $nilaiSaya->nilai_game_2 ?? 0;

                // Logika Badge 2 (nilai)
                if ($game1 >= 30 && $game2 >= 30) {
                    $badgeValue = 1;
                    if ($game1 >= 40 && $game2 >= 40) {
                        $badgeValue = 2;
                    }
                    if ($game1 == 50 && $game2 == 50) {
                        $badgeValue = 3;
                    }

                    Badge::updateOrCreate(
                        ['user_id' => $userId],
                        ['badge2' => $badgeValue]
                    );
                }

                // Logika Badge 3 (waktu) 
                $waktu1 = strtotime($nilaiSaya->waktu_game_1 ?? '00:00:00') - strtotime('TODAY');
                $waktu2 = strtotime($nilaiSaya->waktu_game_2 ?? '00:00:00') - strtotime('TODAY');

                // Konversi batas waktu
                $maks1 = 120; // detik
                $maks2 = 300; // detik

                $persen1 = ($waktu1 / $maks1) * 100;
                $persen2 = ($waktu2 / $maks2) * 100;

                if ($persen1 >= 50 && $persen2 >= 50) {
                    $badge3 = 1;
                    if ($persen1 >= 65 && $persen2 >= 65) {
                        $badge3 = 2;
                    }
                    if ($persen1 >= 80 && $persen2 >= 80) {
                        $badge3 = 3;
                    }

                    Badge::updateOrCreate(
                        ['user_id' => $userId],
                        ['badge3' => $badge3]
                    );
                }
                // Logika Badge 1 (waktu tonton video)
                $waktuVideo = strtotime($nilaiSaya->waktu_video ?? '00:00:00') - strtotime('TODAY'); // detik
                $maxVideoTime = 160; // 2 menit 40 detik

                $persenVideo = ($waktuVideo / $maxVideoTime) * 100;

                if ($persenVideo >= 50) {
                    $badge1 = 1;
                    if ($persenVideo >= 65) {
                        $badge1 = 2;
                    }
                    if ($persenVideo >= 80) {
                        $badge1 = 3;
                    }

                    Badge::updateOrCreate(
                        ['user_id' => $userId],
                        ['badge1' => $badge1]
                    );
                }

                // Ambil badge saat ini
                $badge = Badge::where('user_id', $userId)->first();

                if ($badge) {
                    $b1 = $badge->badge1 ?? 0;
                    $b2 = $badge->badge2 ?? 0;
                    $b3 = $badge->badge3 ?? 0;

                    if ($b1 >= 1 && $b2 >= 1 && $b3 >= 1) {
                        $badge4 = 1;
                        if ($b1 >= 2 && $b2 >= 2 && $b3 >= 2) {
                            $badge4 = 2;
                        }
                        if ($b1 == 3 && $b2 == 3 && $b3 == 3) {
                            $badge4 = 3;
                        }

                        Badge::updateOrCreate(
                            ['user_id' => $userId],
                            ['badge4' => $badge4]
                        );
                    }
                }
            }



            // Ambil jenis leaderboard dari query, default nilai_game_1
            $jenis = $request->query('jenis', 't_nilai_game_1');

            // Validasi kolom yang diizinkan
            $allowed = ['t_nilai_game_1', 't_nilai_game_2'];
            if (!in_array($jenis, $allowed)) {
                abort(404);
            }

            // Ambil leaderboard berdasarkan kolom yang dipilih
            $leaderboard = NilaiSaya::with('user')
                ->orderByDesc($jenis)
                ->take(10)
                ->get();

            return view('nilai', compact('nilaiSaya', 'leaderboard', 'jenis'));
        } else {
            return redirect()->route('login');
        }
    }
}
