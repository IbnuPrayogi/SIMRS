<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terlambat extends Model
{
    use HasFactory;
    protected $table = 'terlambat';

    protected $fillable = [
        'user_id',
        'shift_id',
        'tanggal',
        'waktu_terlambat',
    ];
}
