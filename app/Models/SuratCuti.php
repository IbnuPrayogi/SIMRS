<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SuratCuti extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'cuti';

    protected $fillable = [
        'user_id',
        'nama_surat',
        'tanggal_mulai',
        'tanggal_selesai',
        'alamat',
        'jabatan',
        'keterangan',
        'status',
        'file', 'bagian', 'nama_pengaju', 'tanda_tangan','kepala_bagian','nama_kepala_bagian'
    ];
}
