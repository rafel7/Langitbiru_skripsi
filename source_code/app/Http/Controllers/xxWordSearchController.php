<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordSearchController extends Controller
{
    private $grid = [
        ['C', 'A', 'T', 'D', 'O', 'G'],
        ['O', 'R', 'A', 'N', 'G', 'E'],
        ['D', 'A', 'P', 'P', 'L', 'E'],
        ['B', 'A', 'N', 'A', 'N', 'A'],
        ['G', 'R', 'A', 'P', 'E', 'S'],
    ];

    private $words = ["CAT", "DOG", "ORANGE", "APPLE", "BANANA", "GRAPES"];

    public function index(Request $request)
    {
        if ($request->session()) {
            return view('wordsearch', [
                'grid' => $this->grid,
                'words' => $this->words
            ]);
        } else {
            return redirect()->route('login');
        }
    }

    public function checkWord(Request $request)
    {
        $word = strtoupper($request->input('word'));

        if (in_array($word, $this->words)) {
            return back()->with('success', "Kata '$word' ditemukan! 🎉");
        } else {
            return back()->with('error', "Kata '$word' tidak ditemukan. Coba lagi! ❌");
        }
    }
}
