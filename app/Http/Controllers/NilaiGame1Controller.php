<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Nilai;
use Illuminate\Support\Facades\Log;

class NilaiGame1Controller extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $statusTugas = DB::table('status_tugas')
            ->where('user_id', $userId)
            ->first();

        if ($statusTugas && $statusTugas->cari_kata == 1) {
            return redirect()->route('dashboard.index')
                ->with('error', 'Kamu sudah mengerjakan carikata.');
        }
        return view('game.wordsearch');
    }

    public function store(Request $request)
    {
        Log::info('Data yang diterima:', $request->all());


        $request->validate([
            'nilai' => 'required|integer',
            'waktu_game_1' => 'required|date_format:H:i:s'
        ]);

        //konversi waktu-> nilai
        $parts = explode(':', $request->waktu_game_1);
        $jam = isset($parts[0]) ? (int)$parts[0] : 0;
        $menit = isset($parts[1]) ? (int)$parts[1] : 0;
        $detik = isset($parts[2]) ? (int)$parts[2] : 0;

        $nilai_waktu_game_1 = ($jam * 3600) + ($menit * 60) + $detik;
        $t_nilai_game_1 = ($nilai_waktu_game_1) * 2 + $request->nilai;

        $userId = Auth::id();

        Nilai::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nilai_game_1' => $request->nilai,
                'waktu_game_1' => $request->waktu_game_1,
                't_nilai_game_1' => $t_nilai_game_1
            ]
        );
        DB::table('status_tugas')->updateOrInsert(
            ['user_id' => $userId],
            [
                'cari_kata' => 1,
                'tts' => 0
            ]
        );

        return redirect()->route('game.teka-teki-silang')->with('success', 'Nilai berhasil disimpan!');
    }
}
