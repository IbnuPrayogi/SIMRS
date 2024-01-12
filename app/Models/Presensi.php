<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'cin1',
        'cout1',
        'cin2',
        'cout2',
        'tanggal',
        'nama_bagian'
    ];

    // Relationships or additional methods can be added here
}