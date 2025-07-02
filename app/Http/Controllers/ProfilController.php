<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiSaya;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{

    public function index(Request $request)
    {
        if ($request->session()) {
            return view('profil');
        } else {
            return redirect()->route('login');
        }
    }
}
