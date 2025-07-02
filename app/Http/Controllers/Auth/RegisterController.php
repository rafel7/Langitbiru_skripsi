<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nim' => ['required', 'int'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // 1. Buat user baru dan simpan ke dalam variabel
        $user = User::create([
            'name' => $data['name'],
            'nim' => $data['nim'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // 2. Tambahkan data default ke tabel navigasi
        $defaultTasks = ['tugas_1', 'tugas_2', 'tugas_3'];

        foreach ($defaultTasks as $task) {
            DB::table('navigasi')->insert([
                'user_id'    => $user->id,
                'nama_tugas' => $task,
                'status'     => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Tambahkan data default ke tabel status_tugas
        DB::table('status_tugas')->insert([
            'user_id'      => $user->id,
            'pretest'      => 0,
            'pembelajaran' => 2,
            'cari_kata'    => 2,
            'tts'          => 2,
            'posttest'     => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // 4. tambahakan data default ke tabel badge
        DB::table('badge')->insert([
            'user_id'       => $user->id,
            'badge1'        => 0,
            'badge2'        => 0,
            'badge3'        => 0,
            'badge4'        => 0,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);


        DB::table('nilai')->insert([
            'user_id'       => $user->id,
            'waktu_game_2'  => '00:05:00',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
        return $user;
    }
}
