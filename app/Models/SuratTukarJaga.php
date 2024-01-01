<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SuratTukarJaga extends Model
{
    use HasFactory ,Notifiable;
    protected $table = 'tukar_jaga';

    protected $fillable = [
        'nama_pengaju',
        'waktu',
        'keterangan',
        'bukti',
        'target_tukar_jaga',
        'status',
        'file',
        'jadwal_asli',
        'jadwal_dirubah',
        'termohon',
        'kepala_bagian',
        'kepala_ruangan',
        'termohon',
        'created_at',
        'updated_at',
        'nama_surat',
        'tanda_tangan',
        'nama_kepala_bagian',
        'nama_kepala_ruangan'
    ];
}
