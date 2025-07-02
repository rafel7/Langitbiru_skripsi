<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class pdfcobaController extends Controller
{
    public function index()
    {
        $data = [
            'nama' => 'Rafel Sembilan',
            'judul' => 'Pelatihan Kesadaran Lingkungan',
            'tanggal' => now()->format('d F Y'),
        ];

        $pdf = Pdf::loadView('cobapdf', $data);
        $pdf->setPaper('A4', 'landscape'); // penting: landscape

        return $pdf->download('cobapdf.pdf');
    }
}
