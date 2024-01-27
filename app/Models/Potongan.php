<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    use HasFactory;

    protected $table = 'potongan';

    protected $fillable = [
        'user_id',
        'shift_id',
        'tanggal',
        'waktu_potongan',
        'nama_karyawan'
    ];
}
