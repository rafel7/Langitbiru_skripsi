<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosttestController extends Controller
{
    public function showForm()
    {
        $userId = Auth::id();

        // Cek apakah nilai posttest sudah ada di database
        $nilai = DB::table('nilai')
            ->where('user_id', $userId)
            ->first();

        if ($nilai && !is_null($nilai->nilai_posttest)) {
            return redirect()->route('dashboard.index')
                ->with('error', 'Posttest sudah pernah dikerjakan.');
        }

        $questions = $this->getQuestions(); // fungsi getQuestions()


        return view('posttest.form', compact('questions'));
    }

    public function submitForm(Request $request)
    {
        $userId = Auth::id();

        // Cek apakah nilai postttest sudah ada di database
        $nilai = DB::table('nilai')
            ->where('user_id', $userId)
            ->first();

        if ($nilai && !is_null($nilai->nilai_posttest)) {
            return redirect()->route('dashboard.index')
                ->with('error', 'posttest sudah pernah dikerjakan.');
        }

        $totalQuestions = count($request->except('_token'));


        $questions = $this->getQuestions();
        $questionMap = collect($questions)->keyBy('id');

        $score = 0;
        foreach ($request->except('_token') as $key => $value) {
            if (str_starts_with($key, 'question_')) {
                $questionId = (int) str_replace('question_', '', $key);
                $type = $questionMap[$questionId]['type'] ?? 'likert';

                if ($type === 'pg') {
                    $correctAnswer = $questionMap[$questionId]['answer'] ?? null;
                    $score += ($value === $correctAnswer) ? 5 : 0;
                } elseif ($type === 'likert') {
                    $score += (int) $value;
                }
            }
        }


        //$nilai100 = round(($score / ($totalQuestions * 5)) * 100);

        DB::table('nilai')
            ->updateOrInsert(
                ['user_id' => $userId],
                ['nilai_posttest' => $score]
            );

        DB::table('status_tugas')
            ->updateOrInsert(
                ['user_id' => $userId],
                ['posttest' => 1]
            );

        return redirect()->route('nilai.index')
            ->with('success', 'Nilai kamu: ' . $score . ' ' . $totalQuestions . ' pernyataan.');
    }

    private function getQuestions()
    {
        return [
            [
                'id' => 1,
                'type' => 'pg',
                'question' => 'Apa indikator udara yang paling sering digunakan untuk mengukur kualitas udara?',
                'options' => [
                    'a' => 'PM10',
                    'b' => 'PM2,5',
                    'c' => 'CO2',
                    'd' => 'CO',
                ],
                'answer' => 'b',
            ],
            [
                'id' => 2,
                'type' => 'pg',
                'question' => 'Apa hubungan antara kualitas udara dan kondisi cuaca?',
                'options' => [
                    'a' => 'Hujan memperburuk polusi karena membawa partikel ke permukaan',
                    'b' => 'Angin dapat menyebarkan polusi ke wilayah lain',
                    'c' => 'Cuaca dingin mengurangi pembentukan ozon troposferik',
                    'd' => 'Cuaca dingin menambah pembentukan ozon troposferik',
                ],
                'answer' => 'b',
            ],
            [
                'id' => 3,
                'type' => 'pg',
                'question' => 'Manakah alat yang mengukur kualitas udara?',
                'options' => [
                    'a' => 'Airsensor',
                    'b' => 'Currentsensor',
                    'c' => 'Barometer',
                    'd' => 'Hygrometer',
                ],
                'answer' => 'a',
            ],
            [
                'id' => 4,
                'type' => 'pg',
                'question' => 'Apa kontributor utama polusi di Jakarta?',
                'options' => [
                    'a' => 'Pembakaran batu bara',
                    'b' => 'Pembakaran terbuka',
                    'c' => 'Aktivitas konstruksi',
                    'd' => 'Asap kendaraan',
                ],
                'answer' => 'd',
            ],
            [
                'id' => 5,
                'type' => 'pg',
                'question' => 'Mengapa anak-anak lebih rentan terhadap dampak polusi udara dibanding orang dewasa??',
                'options' => [
                    'a' => 'Tingkat metabolisme anak lebih rendah sehingga penyerapan polutan meningkat',
                    'b' => 'Tekanan saat menghirup udara lebih tinggi',
                    'c' => 'Anak-anak jarang terpapar sinar matahari',
                    'd' => 'Frekuensi pernapasan anak lebih tinggi',
                ],
                'answer' => 'd',
            ],
            [
                'id' => 6,
                'type' => 'likert',
                'question' => 'Saya merasa khawatir dengan dampak jangka panjang polusi udara terhadap kesehatan saya dan keluarga.'
            ],
            [
                'id' => 7,
                'type' => 'likert',
                'question' => 'Saya merasa tidak nyaman dan terganggu ketika berada di jalanan yang penuh dengan asap kendaraan.'
            ],
            [
                'id' => 8,
                'type' => 'likert',
                'question' => 'Saya percaya bahwa setiap orang, termasuk saya, memiliki kewajiban moral untuk menjaga kebersihan udara.'
            ],
            [
                'id' => 9,
                'type' => 'likert',
                'question' => 'Saya mendukung kebijakan pemerintah yang lebih ketat, seperti pembatasan usia kendaraan atau perluasan zona ganjil-genap, untuk menekan polusi'
            ],
            [
                'id' => 10,
                'type' => 'likert',
                'question' => 'Merasa bangga atau senang ketika melakukan tindakan yang ramah lingkungan (misalnya, memilih bersepeda daripada naik motor) adalah hal yang wajar bagi saya.'
            ],
            [
                'id' => 11,
                'type' => 'likert',
                'question' => 'Saya berniat untuk lebih sering menggunakan transportasi umum atau berjalan kaki untuk perjalanan yang memungkinkan.',
            ],
            [
                'id' => 12,
                'type' => 'likert',
                'question' => 'Dalam sebulan terakhir, saya telah secara sadar memilih alternatif selain kendaraan pribadi (misal: jalan kaki, sepeda, KRL, ojek online) untuk mengurangi jejak emisi saya.',
            ],
            [
                'id' => 13,
                'type' => 'likert',
                'question' => 'Saya bersedia membayar sedikit lebih mahal untuk produk atau layanan yang jelas-jelas lebih ramah lingkungan.',
            ],
            [
                'id' => 14,
                'type' => 'likert',
                'question' => 'Saya secara aktif mencari informasi atau tips tentang cara hidup yang lebih ramah lingkungan untuk mengurangi polusi.',
            ],
            [
                'id' => 15,
                'type' => 'likert',
                'question' => 'Saya akan mempertimbangkan untuk menegur secara sopan atau memberikan edukasi kepada orang di sekitar saya yang melakukan tindakan pencemaran udara (misalnya, membakar sampah).',
            ],

        ];
    }
}
