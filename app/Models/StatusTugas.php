<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTugas extends Model
{
    use HasFactory;

    protected $table = 'status_tugas';

    protected $fillable = ['user_id', 'pretest', 'pembelajaran
', 'cari_kata', 'tts', 'posttest'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
