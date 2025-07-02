<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }


        $user = Auth::user();


        $statusTugas = DB::table('status_tugas')->where('user_id', $user->id)->first();

        return view('dashboard', [
            'statusTugas' => $statusTugas
        ]);
    }
}
