<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavigasiSeeder extends Seeder
{
    public function run()
    {
        $tugasList = ['tugas_1', 'tugas_2', 'tugas_3'];

        foreach ($tugasList as $tugas) {
            DB::table('navigasi')->insert([
                'user_id'    => 2, // ID user Rafel
                'nama_tugas' => $tugas,
                'status'     => 0, // status 0 = belum selesai
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
