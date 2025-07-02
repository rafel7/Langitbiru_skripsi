<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiExport;

class AdminExportController extends Controller
{
    public function export()
    {
        return Excel::download(new NilaiExport, 'data_nilai.xlsx');
    }
}
