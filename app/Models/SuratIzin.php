<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SuratIzin extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'izin';

    protected $fillable = [
        'nama_pengaju','waktu',
        'durasi',
        'keterangan','bukti',
        'status',
        'tanda_tangan',
        'nama_surat',
        'file', 'tanggal_mulai' , 'tanggal_selesai' ,'bagian', 'tanggal_izin','manajer','nama_manajer'
    ];

}
