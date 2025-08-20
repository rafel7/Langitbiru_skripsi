<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        Log::info('Login attempt:', ['nim' => $request->nim]);

        $credentials = $request->only('nim', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Log::info('User logged in:', ['nim' => $request->nim, 'status' => $user->status]);

            // Cek apakah NIM adalah "admin"
            if ($user->nim === '0') {
                return redirect('/admin');
            }



            if ($user->status == 1) {
                return redirect('/admin');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        Log::warning('Login failed:', ['nim' => $request->nim]);
        return back()->withErrors(['nim' => 'nim atau password salah.']);
    }

    // Fungsi untuk logout
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Hapus sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect('/login')->with('success', 'Logout berhasil!');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard'); // Redirect ke dashboard jika sudah login
        }
        return view('auth.login'); // Pastikan file auth/login.blade.php ada
    }
}
