<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSaya extends Model
{
    protected $table = 'nilai';
    //  relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'user_id',
        'nilai_pretest',
        'nilai_posttest',
        'nilai_game_1',
        'nilai_game_2',
    ];
}
