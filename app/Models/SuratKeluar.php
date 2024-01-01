<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SuratKeluar extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'surat_keluar';
    protected $fillable = [
        'nama_surat',
        'kategori_surat',
        'tanggal_dibuat',
        'jenis_surat',
        'pembuat_surat',
        'tujuan_surat',
        'file',
        'status',
        'kode_surat'
    ];
}
