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
        'cin1',
        'cout1',
        'cin2',
        'cout2',
        'lama_waktu'
    ];
}
