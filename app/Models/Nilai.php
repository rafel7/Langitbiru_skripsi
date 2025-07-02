<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    use HasFactory;

    protected $table = 'nilai';  // Nama tabel di database

    protected $fillable = [
        'user_id',
        'nilai_game_1',
        'waktu_game_1',
        't_nilai_game_1',
        'nilai_game_2',
        'waktu_game_2',
        't_nilai_game_2'
    ];
}
