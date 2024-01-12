<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPresensi extends Model
{
    use HasFactory;

    protected $table = 'inoutdata';

    protected $fillable = [
        'badgenumber',
        'username',
        'deptname',
        'sDate',
        'stime',
        'eDate',
        // Tambahkan atribut lain sesuai kebutuhan
    ];
}
