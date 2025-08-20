<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Nilai;

class VideoController extends Controller
{
    public function simpanWaktuVideo(Request $request)
    {
        $userId = Auth::id();
        $waktuSisa = $request->input('waktu_sisa');

        $nilai = DB::table('nilai')->where('user_id', $userId)->first();

        if ($nilai) {
            $waktuDB = $nilai->waktu_video;

            // Update hanya jika lebih besar atau masih null
            if (is_null($waktuDB) || strtotime($waktuSisa) > strtotime($waktuDB)) {
                DB::table('nilai')
                    ->where('user_id', $userId)
                    ->update(['waktu_video' => $waktuSisa]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
