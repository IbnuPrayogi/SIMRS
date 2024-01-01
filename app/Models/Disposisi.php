<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi'; // Ganti 'nama_tabel' dengan nama tabel yang sesuai

    protected $fillable = [
        'id_surat',
        'nama_surat',
        'status',
        'deskripsi',
        'created_at',
        'updated_at',
        // Tambahkan kolom-kolom lainnya sesuai kebutuhan
    ];
}
