<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pembelajaran1Controller extends Controller
{
    // Fungsi untuk menampilkan halaman dashboard
    public function index()
    {

        return view('pembelajaran/video1');
    }
}
