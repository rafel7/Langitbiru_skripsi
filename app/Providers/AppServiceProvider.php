<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function boot()
    {
     \URL::forceScheme('https');

        View::composer('*', function ($view) {

            $userId = Auth::id();  // ambil ID user yang login

            $status = DB::table('navigasi')
                ->where('user_id', $userId)
                ->pluck('status', 'nama_tugas')
                ->toArray();

            // Cek apakah user punya nilai pretest di tabel nilai
            $nilai = DB::table('nilai')
                ->where('user_id', $userId)
                ->first();

            // logika tombol: jika nilai pretest sudah terisi, pretest tidak bisa diklik
            $isPretestDisabled = $nilai && !is_null($nilai->nilai_pretest);

            $timeline_status = [
                'pretest'      => !$isPretestDisabled ? ($status['pretest'] ?? false) : false,
                'pembelajaran' => $status['pembelajaran'] ?? false,
                'gamifikasi'   => $status['gamifikasi'] ?? false,
                'posttest'     => $status['posttest'] ?? false,
            ];


            $view->with('timeline_status', $timeline_status);
            $view->with('user_nilai', $nilai);
        });
    }
}
