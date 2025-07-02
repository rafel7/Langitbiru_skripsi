<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::logout();  // Logout pengguna
        return redirect('/login')->with('success', 'Logout berhasil!');  // Redirect ke halaman login
    }
}
