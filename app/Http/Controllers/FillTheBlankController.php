<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FillTheBlankController extends Controller
{
    private $questions = [
        [
            'sentence' => 'Ibu pergi ke ____ untuk membeli sayur.',
            'answer' => 'pasar'
        ],
        [
            'sentence' => 'Burung dapat ____ di udara.',
            'answer' => 'terbang'
        ],
        [
            'sentence' => 'Matahari terbit dari ____.',
            'answer' => 'timur'
        ]
    ];

    public function index(Request $request)
    {
        if ($request->session()) {
            return view('filltheblank', ['questions' => $this->questions]);
        } else {
            return redirect()->route('login');
        }
    }

    public function checkAnswers(Request $request)
    {
        $userAnswers = $request->input('answers');
        $results = [];
        $score = 0;

        foreach ($this->questions as $index => $question) {
            $userAnswer = strtolower(trim($userAnswers[$index] ?? ''));
            $correctAnswer = strtolower($question['answer']);

            if ($userAnswer === $correctAnswer) {
                $score++;
                $results[] = [
                    'sentence' => $question['sentence'],
                    'user_answer' => $userAnswer,
                    'correct' => true
                ];
            } else {
                $results[] = [
                    'sentence' => $question['sentence'],
                    'user_answer' => $userAnswer,
                    'correct' => false,
                    'correct_answer' => $correctAnswer
                ];
            }
        }

        return view('filltheblank', [
            'questions' => $this->questions,
            'results' => $results,
            'score' => $score
        ]);
    }
}
