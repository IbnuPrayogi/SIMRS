<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shifts';
    protected $fillable = [
        'nama_shift',
        'kode_shift',
        'bagian',
        'jam_masuk',
        'jam_pulang',
        'lama_waktu'
    ];
}
