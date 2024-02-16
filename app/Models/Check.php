<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;

    protected $table='check_data';
    protected $fillable=[
        'userid',
        'nama_karyawan',
        'waktu',
  
    ];
}
