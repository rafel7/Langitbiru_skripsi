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

        // Simpan jawaban benar ke session berdasarkan id soal
        session(['pretest_answers' => collect($questions)->pluck('answer', 'id')->toArray()]);

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

        $storedAnswers = session('pretest_answers', []);
        $score = 0;

        foreach ($storedAnswers as $id => $correctIndex) {
            $input = $request->input('question_' . $id);
            if ((int)$input === (int)$correctIndex) {
                $score++;
            }
        }

        $nilai100 = round($score * 100) / 15;
        // Simpan nilai ke kolom 'nilai_pretest'
        DB::table('nilai')
            ->updateOrInsert(
                ['user_id' => $userId],
                ['nilai_pretest' => $nilai100]
            );

        // simpan nilai 1 (true) ke navigasi
        DB::table('status_tugas')
            ->updateOrInsert(
                ['user_id' => $userId],
                [
                    'pretest' => 1,
                    'pembelajaran' => 0
                ]
            );

        return redirect()->route('video1')->with('success', 'Nilai kamu: ' . $score . ' dari ' . count($storedAnswers));
    }

    private function getQuestions()
    {
        return [
            [
                'id' => 1,
                'question' => 'Apa Penyebab utama polusi udara di Jakarta?',
                'options' => ['Pembakaran batu bara', 'Pembakaran terbuka', 'Asap kendaraan', 'Aktivitas konstruksi'],
                'answer' => 2
            ],
            [
                'id' => 2,
                'question' => 'Indikator udara yang paling sering digunakan untuk mengukur kualitas udara adalah....',
                'options' => ['CO', 'CO2', 'PM10', 'PM2,5'],
                'answer' => 3
            ],
            [
                'id' => 3,
                'question' => 'Bagaimana masyarakat dapat membantu mengurangi polusi udara terkait pembakaran sampah terbuka?',
                'options' => [
                    'Dengan membakar sampah plastik di area terbuka',
                    'Dengan mendaur ulang lebih banyak sampah ',
                    'Dengan membakar sampah organik untuk menghasilkan energi',
                    'Dengan membuang sampah di sungai untuk mengurangi polusi udara'
                ],
                'answer' => 1
            ],
            [
                'id' => 4,
                'question' => 'Apa hubungan antara kualitas udara dan kondisi cuaca?',
                'options' => [
                    'Hujan memperburuk polusi karena membawa partikel ke permukaan',
                    'Angin dapat menyebarkan polusi ke wilayah lain',
                    'Cuaca dingin mengurangi pembentukan ozon troposferik',
                    'Cuaca tidak memengaruhi kualitas udara sama sekali'
                ],
                'answer' => 1
            ],
            [
                'id' => 5,
                'question' => 'Manakah dari aktivitas berikut yang tidak langsung menyumbang polusi udara?',
                'options' => [
                    'Mengemudi mobil berbahan bakar bensin',
                    'Menggunakan listrik dari pembangkit batu bara',
                    'Membakar sampah di pekarangan',
                    'Membuang sampah plastik ke laut'
                ],
                'answer' => 3
            ],
            [
                'id' => 6,
                'question' => 'Apa tanggapanmu masih banyak orang yang membakar sampah di lingkungan rumahnya??',
                'options' => [
                    'Itu hal biasa saja, tidak perlu dikhawatirkan.',
                    'Membakar sampah baik untuk mengurangi volume sampah.',
                    'Asalkan asapnya tidak mengganggu tetangga, tidak masalah.',
                    'Tidak baik, karena membakar sampah mencemari udara dan merusak kesehatan'
                ],
                'answer' => 3
            ],
            [
                'id' => 7,
                'question' => 'Apa tindakan yang bisa kamu lakukan untuk membantu mengurangi polusi udara?',
                'options' => [
                    'Membakar sampah plastik agar cepat habis.',
                    'Mengendarai motor sendiri ke sekolah setiap hari.',
                    'Mengurangi penggunaan kendaraan bermotor dan mulai naik transportasi umum.',
                    'Membiarkan AC menyala terus meskipun tidak digunakan.'
                ],
                'answer' => 2
            ],
            [
                'id' => 8,
                'question' => 'Apa tindakan yang bisa kamu lakukan untuk membantu mengurangi polusi udara?',
                'options' => [
                    'Karena kualitas udara yang buruk dapat memicu gangguan kesehatan dan menurunkan produktivitas.',
                    'Karena udara yang tercemar bisa menambah imunitas tubuh.',
                    'Supaya aktivitas pembakaran sampah tetap bisa dilakukan bebas.',
                    'Karena udara kotor menunjukkan daerah tersebut berkembang secara industri'
                ],
                'answer' => 0
            ],
            [
                'id' => 9,
                'question' => 'Apa komitmen pribadi yang ingin kamu lakukan untuk menjaga kualitas udara?',
                'options' => [
                    'Membakar sampah rumah tangga agar lebih cepat bersih',
                    'Mengurangi penggunaan masker supaya terbiasa dengan polusi.',
                    'Mengurangi penggunaan kendaraan pribadi dan lebih memilih transportasi ramah lingkungan.',
                    'Membiarkan kendaraan menyala dalam waktu lama meskipun tidak digunakan.'
                ],
                'answer' => 2
            ],
            [
                'id' => 10,
                'question' => 'Apa yang kamu rasakan setelah mengetahui bahwa banyak orang meninggal akibat dampak polusi udara?',
                'options' => [
                    'Cukup kaget, namun saya pikir solusi teknologi akan mengatasi semuanya tanpa perubahan perilaku individu.',
                    'Merasa tergugah, namun sulit untuk percaya bahwa tindakan individu bisa memberi dampak berarti.',
                    'Merasa bertanggung jawab secara sosial dan terdorong untuk berperan aktif dalam perubahan kebijakan dan gaya hidup ramah lingkungan.',
                    'Menganggap bahwa isu ini hanya relevan di kota besar dan tidak berdampak langsung pada saya.'
                ],
                'answer' => 2
            ],
            [
                'id' => 11,
                'question' => 'Apa tindakan sederhana yang dapat kamu lakukan untuk menunjukkan kepedulian terhadap kualitas udara di lingkungan sekitar?',
                'options' => [
                    'Mengurangi penggunaan kendaraan bermotor pribadi',
                    'Tidak peduli asal bisa sampai tujuan cepat',
                    'Membiarkan kendaraan menyala terus saat berhenti lama',
                    ' Mengikuti ajakan teman membakar sampah'
                ],
                'answer' => 0
            ],
            [
                'id' => 12,
                'question' => 'Ketika melihat orang tua membakar sampah di halaman rumah dan menimbulkan asap tebal, sikapmu sebaiknya...',
                'options' => [
                    'Membiarkannya karena sudah biasa',
                    'Mengingatkan dengan sopan bahwa itu bisa mencemari udara',
                    'Ikut membantu membakar supaya cepat selesai',
                    'Mengambil foto dan membahas di media sosial'
                ],
                'answer' => 1
            ],
            [
                'id' => 13,
                'question' => 'Bagaimana kamu menunjukkan komitmen pribadi dalam menjaga kualitas udara setiap hari?',
                'options' => [
                    'Mengajak teman menggunakan transportasi umum atau sepeda',
                    'Membakar sampah agar cepat bersih',
                    'Lebih sering memakai kendaraan pribadi untuk kenyamanan',
                    'Tidak terlalu peduli, itu urusan pemerintah'
                ],
                'answer' => 0
            ],
            [
                'id' => 14,
                'question' => 'Sebagai mahasiswa yang peduli lingkungan, tindakan nyata yang bisa kamu rencanakan untuk jangka panjang dalam mengurangi polusi udara adalah..',
                'options' => [
                    'Fokus pada akademik saja',
                    'Membuat komunitas sadar lingkungan di kampus',
                    'Mengeluh tentang udara panas setiap hari di media sosial',
                    'Tidak membuang sampah sembarangan'
                ],
                'answer' => 1
            ],
            [
                'id' => 15,
                'question' => 'Temanmu bilang polusi udara bukan masalah penting. Apa respons aktifmu?',
                'options' => [
                    'Mengiyakan agar tidak berdebat',
                    'Mengalihkan pembicaraan ke topik lain',
                    'Menanggapi dengan data bahwa polusi berdampak pada kesehatan',
                    'Diam saja karena itu pendapatnya'
                ],
                'answer' => 2
            ],
        ];
    }
}
