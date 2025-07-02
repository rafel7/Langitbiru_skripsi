<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SidebarController extends Controller
{
    public function index()
    {
        $userId = Auth::id();  // id user yang login

        // ambil data status tugas dari tabel navigasi
        $timeline_status = DB::table('navigasi')
            ->where('user_id', $userId)
            ->pluck('status', 'nama_tugas')
            ->toArray();

        return view('layouts.sidebar', compact('timeline_status'));
    }
    public static function getStatusTugas()
    {
        $userId = Auth::id();

        // Ambil data dari tabel status_tugas berdasarkan user yang login
        return DB::table('status_tugas')->where('user_id', $userId)->first();
    }

    public function show($filename)
    {
        $titles = [
            'materi1' => 'Pengenalan',
            'materi2' => 'Isi',
            'materi3' => 'Penutup'
        ];

        $name = pathinfo($filename, PATHINFO_FILENAME);
        $judul = $titles[$name] ?? $name;  // fallback ke nama file kalau gak ada judul

        return view('slides.show', compact('filename', 'judul'));
    }
}
