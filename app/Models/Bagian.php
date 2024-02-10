<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    use HasFactory;

    protected $table = 'bagian'; // Ganti 'nama_tabel' dengan nama tabel yang sesuai

    protected $fillable = [
        'nama_bagian',
        'created_at',
        'updated_at',
    ];
}
