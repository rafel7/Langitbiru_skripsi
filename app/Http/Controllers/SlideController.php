<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    public function selesai(Request $request)
    {
        $userId = Auth::id();

        DB::table('status_tugas')->updateOrInsert(
            ['user_id' => $userId],
            [
                'cari_kata' => 0,
                'pembelajaran' => 3
            ]
        );

        return redirect('/game/wordsearch');
    }

    public function show($filename)
    {
        // tambahin ekstensi otomatis jika lupa
        if (!str_ends_with($filename, '.pdf')) {
            $filename .= '.pdf';
        }

        // cek apakah file ada
        if (!file_exists(public_path('slides/' . $filename))) {
            abort(404, 'File tidak ditemukan!');
        }

        // Mapping judul yang lebih enak dibaca
        $titles = [
            'materi1' => 'Pengenalan',
            //'materi2' => 'Isi',
        ];

        $name = pathinfo($filename, PATHINFO_FILENAME);
        $judul = $titles[$name] ?? $name;

        // urutan slide
        $slides = array_keys($titles);
        $currentIndex = array_search($name, $slides);

        // Hitung next dan prev
        $next = $currentIndex !== false && isset($slides[$currentIndex + 1]) ? $slides[$currentIndex + 1] : null;
        $prev = $currentIndex !== false && isset($slides[$currentIndex - 1]) ? $slides[$currentIndex - 1] : null;



        // Ambil nama file tanpa .pdf
        $name = pathinfo($filename, PATHINFO_FILENAME);

        // Jika nama ada di daftar, pakai judul mapping, kalau nggak pakai nama file
        $judul = $titles[$name] ?? $name;

        return view('slides.show', compact('filename', 'judul', 'next', 'prev'));
    }
}
