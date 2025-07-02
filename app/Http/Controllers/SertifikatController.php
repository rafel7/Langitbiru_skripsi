<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatController extends Controller
{
    public function download()
    {
        $user = Auth::user();
        $data = [
            'name' => $user->name,
        ];

        $pdf = Pdf::loadView('sertifikat.template', $data);
        $pdf->setPaper('A4', 'landscape'); // landscape

        return $pdf->download('Sertifikat-' . $user->name . '.pdf');
    }
}
