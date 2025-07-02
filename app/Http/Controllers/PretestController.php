<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PretestController extends Controller
{
    public function showForm()
    {
        $userId = Auth::id();

        // Cek apakah nilai pretest sudah ada di database
        $nilai = DB::table('nilai')
            ->where('user_id', $userId)
            ->first();

        if ($nilai && !is_null($nilai->nilai_pretest)) {
            return redirect()->route('dashboard.index')
                ->with('error', 'Pretest sudah pernah dikerjakan.');
        }

        $questions = $this->getQuestions(); // fungsi getQuestions()


        return view('pretest.form', compact('questions'));
    }

    public function submitForm(Request $request)
    {
        $userId = Auth::id();

        // Cek apakah nilai pretest sudah ada di database
        $nilai = DB::table('nilai')
            ->where('user_id', $userId)
            ->first();

        if ($nilai && !is_null($nilai->nilai_pretest)) {
            return redirect()->route('dashboard.index')
                ->with('error', 'Pretest sudah pernah dikerjakan.');
        }

        $totalQuestions = count($request->except('_token'));

        $score = 0;
        foreach ($request->except('_token') as $key => $value) {
            if (str_starts_with($key, 'question_')) {
                $score += (int) $value;
            }
        }

        //$nilai100 = round(($score / ($totalQuestions * 5)) * 100);

        DB::table('nilai')
            ->updateOrInsert(
                ['user_id' => $userId],
                ['nilai_pretest' => $score]
            );

        DB::table('status_tugas')
            ->updateOrInsert(
                ['user_id' => $userId],
                ['pretest' => 1, 'pembelajaran' => 0]
            );

        return redirect()->route('video1')
            ->with('success', 'Nilai kamu: ' . $score . ' ' . $totalQuestions . ' pernyataan.');
    }

    private function getQuestions()
    {
        return [
            [
                'id' => 1,
                'question' => 'Saya tahu bahwa asap dari kendaraan pribadi (motor dan mobil) adalah sumber utama polusi udara di kota besar.',
            ],
            [
                'id' => 2,
                'question' => 'Saya memahami bahwa polusi udara dapat menyebabkan masalah kesehatan serius seperti Infeksi Saluran Pernapasan Akut (ISPA) dan asma.',
            ],
            [
                'id' => 3,
                'question' => 'Saya tahu bahwa aktivitas membakar sampah, terutama sampah plastik, melepaskan zat-zat berbahaya ke udara.',
            ],
            [
                'id' => 4,
                'question' => 'Saya mengerti bahwa memilih untuk menggunakan transportasi umum (seperti KRL atau Transjakarta) adalah salah satu cara efektif untuk mengurangi polusi udara.'
            ],
            [
                'id' => 5,
                'question' => 'Saya tahu bahwa keberadaan pohon dan ruang terbuka hijau di perkotaan penting untuk membantu menyaring udara kotor.'
            ],
            [
                'id' => 6,
                'question' => 'Saya merasa khawatir dengan dampak jangka panjang polusi udara terhadap kesehatan saya dan keluarga.'
            ],
            [
                'id' => 7,
                'question' => 'Saya merasa tidak nyaman dan terganggu ketika berada di jalanan yang penuh dengan asap kendaraan.'
            ],
            [
                'id' => 8,
                'question' => 'Saya percaya bahwa setiap orang, termasuk saya, memiliki kewajiban moral untuk menjaga kebersihan udara.'
            ],
            [
                'id' => 9,
                'question' => 'Saya mendukung kebijakan pemerintah yang lebih ketat, seperti pembatasan usia kendaraan atau perluasan zona ganjil-genap, untuk menekan polusi'
            ],
            [
                'id' => 10,
                'question' => 'Merasa bangga atau senang ketika melakukan tindakan yang ramah lingkungan (misalnya, memilih bersepeda daripada naik motor) adalah hal yang wajar bagi saya.'
            ],
            [
                'id' => 11,
                'question' => 'Saya berniat untuk lebih sering menggunakan transportasi umum atau berjalan kaki untuk perjalanan yang memungkinkan.',
            ],
            [
                'id' => 12,
                'question' => 'Dalam sebulan terakhir, saya telah secara sadar memilih alternatif selain kendaraan pribadi (misal: jalan kaki, sepeda, KRL, ojek online) untuk mengurangi jejak emisi saya.',
            ],
            [
                'id' => 13,
                'question' => 'Saya bersedia membayar sedikit lebih mahal untuk produk atau layanan yang jelas-jelas lebih ramah lingkungan.',
            ],
            [
                'id' => 14,
                'question' => 'Saya secara aktif mencari informasi atau tips tentang cara hidup yang lebih ramah lingkungan untuk mengurangi polusi.',
            ],
            [
                'id' => 15,
                'question' => 'Saya akan mempertimbangkan untuk menegur secara sopan atau memberikan edukasi kepada orang di sekitar saya yang melakukan tindakan pencemaran udara (misalnya, membakar sampah).',
            ],

        ];
    }
}
