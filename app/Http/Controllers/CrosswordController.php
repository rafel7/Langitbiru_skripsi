<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CrosswordController extends Controller
{
    //public function index()
    //{
    //    return view('crossword');
    //}
    // Halaman utama permainan
    public function index(Request $request)
    {
        if (Auth::check()) {


            // Soal dan jawaban
            $crossword = [
                ['kata' => 'LARAVEL', 'petunjuk' => 'Framework PHP terkenal'],
                ['kata' => 'ROUTE', 'petunjuk' => 'Digunakan untuk mengatur URL'],
                ['kata' => 'MIGRATION', 'petunjuk' => 'Digunakan untuk mengelola database di Laravel'],
            ];

            return view('crossword', compact('crossword'));
        } else {
            return redirect()->route('login');
        }
    }

    // Cek jawaban
    public function check(Request $request)
    {
        $answers = [
            'LARAVEL',
            'ROUTE',
            'MIGRATION'
        ];

        $score = 0;
        foreach ($request->input('jawaban') as $key => $jawaban) {
            if (strtoupper($jawaban) === $answers[$key]) {
                $score += 10; // Setiap jawaban benar mendapatkan 10 poin
            }
        }

        return redirect()->route('crossword.index')->with('score', $score);
    }
}
