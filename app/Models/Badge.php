<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $table = 'badge';

    protected $fillable = ['user_id', 'badge1', 'badge2', 'badge3', 'badge4'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
