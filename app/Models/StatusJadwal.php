<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusJadwal extends Model
{
    use HasFactory;

    protected $table='status_jadwal';

    protected $fillable = [
        'bulan',
        'tahun',
        'status',
        'nama_bagian',
       
    ];
}
