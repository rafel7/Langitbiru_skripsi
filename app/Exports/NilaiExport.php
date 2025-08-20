<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return DB::table('nilai')
            ->join('users', 'nilai.user_id', '=', 'users.id')
            ->select('users.nim', 'nilai.nilai_pretest', 'nilai.nilai_posttest', 'nilai.nilai_game_1', 'nilai.nilai_game_2', 'nilai.t_nilai_game_1', 'nilai.t_nilai_game_2')
            ->get();
    }

    public function headings(): array
    {
        return ['NIM', 'Pretest', 'Posttest', 'Game 1', 'Game 2', 'Totla Game 1', 'Total Game 2'];
    }
}
