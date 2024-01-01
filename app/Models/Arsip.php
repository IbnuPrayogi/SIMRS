<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;
    protected $table = 'arsips';

    protected $fillable = [
        'id', 'nama_arsip','kode_arsip','perihal', 'kategori', 'tanggal_dibuat', 'tanggal_selesai', 'lokasi_arsip', 'file'
    ];

}
