<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'lapangan_id',
        'date',
        'start_time',
        'end_time',
        'is_available',
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}
