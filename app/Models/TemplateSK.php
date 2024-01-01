<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TemplateSK extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'template_SK';

    protected $fillable = [
        'perihal',
        'hari_tanggal',
        'waktu',
        'tempat',
        'tanggal_surat',
        'pembuat_surat',
        'id_surat',
        'tanda_tangan'
    ];
}
