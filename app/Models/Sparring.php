<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparring extends Model
{
    protected $fillable = [
        'user_id',
        'lapangan_id',
        'date',
        'start_time',
        'end_time',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}
