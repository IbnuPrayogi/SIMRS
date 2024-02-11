<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table = 'potonganizin';

    protected $fillable = [
        'nama_karyawan',
        'shift_id',
        'tanggal',
        'waktu_izin',
        'bagian'
    ];
}
