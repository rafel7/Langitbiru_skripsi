<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;





class TekaTekiSilangController extends Controller
{
    public function index()
    {
        $questions = [
            1 => ['direction' => 'across', 'length' => 4, 'question' => 'Fenomena kabut tebal bercampur polusi'],
            2 => ['direction' => 'down', 'length' => 5, 'question' => 'Penyaring partikel udara'],
            3 => ['direction' => 'accross', 'length' => 10, 'question' => 'Alat ukur kualitas udara'],
            4 => ['direction' => 'down', 'length' => 4, 'question' => 'Faktor Polusi'],
            5 => ['direction' => 'down', 'length' => 4, 'question' => 'Organ yang beresiko pada polusi'],
        ];
        $userId = Auth::id();
        $nilai = Nilai::where('user_id', $userId)->first();
        $waktusisa = $nilai?->waktu_game_2 ?? '00:05:00';

        $filled = [];
        $answers = [];

        return view('game.teka-teki-silang', compact('questions', 'filled', 'answers', 'waktusisa'));
    }


    public function submit(Request $request)
    {
        $answers = $request->input('answers', []);

        $map = [
            1 => ['direction' => 'across', 'start' => [1, 4], 'answer' => 'SMOG'],
            2 => ['direction' => 'down',   'start' => [1, 5], 'answer' => 'MASKER'],
            3 => ['direction' => 'across',   'start' => [3, 1], 'answer' => 'AQIUSMETER'],
            4 => ['direction' => 'down', 'start' => [3, 1], 'answer' => 'ASAP'],
            5 => ['direction' => 'down',   'start' => [1, 10], 'answer' => 'PARU'],
        ];

        $skor = 0;
        $filled = [];

        foreach ($map as $no => $info) {
            $userAnswer = strtoupper($answers[$no] ?? '');
            $correctAnswer = strtoupper($info['answer']);
            $length = strlen($correctAnswer);
            [$row, $col] = $info['start'];

            $isAllCorrect = true;

            for ($i = 0; $i < $length; $i++) {
                $r = $info['direction'] === 'across' ? $row : $row + $i;
                $c = $info['direction'] === 'across' ? $col + $i : $col;
                $key = "$r-$c";



                $userChar = $userAnswer[$i] ?? '';
                $correctChar = $correctAnswer[$i];
                $isCorrect = $userChar === $correctChar;

                if (!$isCorrect) {
                    $isAllCorrect = false;
                }

                // Cek apakah posisi ini sudah pernah diisi huruf yang benar
                if (isset($filled[$key]) && $filled[$key]['correct']) {
                    continue; // jangan timpa huruf yang sudah benar
                }

                $filled[$key] = [
                    'char' => $userChar,
                    'correct' => $isCorrect
                ];
            }
            // Kalau semua huruf benar, tambah skor 1
            if ($isAllCorrect) {
                $skor += 10;
            }
        }

        // Cek data yang diterima
        Log::info('Data yang diterima: ', $request->all());
        Log::info('Waktu Game: ' . $request->input('waktu_game_2'));
        Log::info('Skor: ' . $skor);

        //ambil nilai
        $waktuhitung = $request->input('waktu_game_2');
        //ubah detik
        list($h, $m, $s) = explode(':', $waktuhitung);
        $waktuhitung = ($h * 3600) + ($m * 60) + $s;
        //total max waktu
        $totaldetik = 300;
        //waktu sisa
        $sisadetik = max(0, $totaldetik - $waktuhitung);
        //waktu benar
        $waktusisa = gmdate("H:i:s", $sisadetik);
        // Simpan skor ke database
        Nilai::updateOrCreate(

            ['user_id' => Auth::id()],
            [
                'nilai_game_2' => $skor,
                'waktu_game_2' => $waktusisa,
                't_nilai_game_2' => $skor + $sisadetik * 2
            ]

        );

        Log::info('Nilai game 2 berhasil disimpan untuk user_id: ' . Auth::id());


        $questions = [
            1 => ['direction' => 'across', 'length' => 4, 'question' => 'Fenomena kabut tebal bercampur polusi'],
            2 => ['direction' => 'down', 'length' => 6, 'question' => 'Penyaring partikel udara'],
            3 => ['direction' => 'across', 'length' => 10, 'question' => 'Alat ukur kualitas udara'],
            4 => ['direction' => 'down', 'length' => 4, 'question' => 'Faktor Polusi'],
            5 => ['direction' => 'down', 'length' => 4, 'question' => 'Organ yang beresiko pada polusi'],
        ];

        return view('game.teka-teki-silang', compact('questions', 'filled', 'answers', 'waktusisa'))
            ->with('success', 'Nilai berhasil disimpan!');
    }


    public function submit2(Request $request)
    {
        $userId = Auth::id();

        // Ambil waktu
        $waktuhitung = $request->input('waktu_game_2');
        list($h, $m, $s) = explode(':', $waktuhitung);
        $waktuhitung = ($h * 3600) + ($m * 60) + $s;

        $totaldetik = 300;
        $sisadetik = max(0, $totaldetik - $waktuhitung);
        $waktusisa = gmdate("H:i:s", $sisadetik);

        // Update status_tugas
        DB::table('status_tugas')->updateOrInsert(
            ['user_id' => $userId],
            ['posttest' => 0, 'tts' => 1] // ⬅️ Pastikan kolom2 ini ada
        );

        // Wajib update nilai jika belum tersimpan
        Nilai::updateOrCreate(
            ['user_id' => $userId],
            [
                'waktu_game_2' => $waktusisa,
                't_nilai_game_2' => DB::raw('COALESCE(nilai_game_2, 0) + ' . ($sisadetik * 2))
            ]
        );

        return redirect()->route('posttest.form');
    }
}
