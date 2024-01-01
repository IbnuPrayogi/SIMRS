<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table='jadwals';

    protected $fillable = [
        'user_id',
        'bulan',
        'tanggal_1',
        'tanggal_2',
        'tanggal_3',
        'tanggal_4',
        'tanggal_5',
        'tanggal_6',
        'tanggal_7',
        'tanggal_8',
        'tanggal_9',
        'tanggal_10',
        'tanggal_11',
        'tanggal_12',
        'tanggal_13',
        'tanggal_14',
        'tanggal_15',
        'tanggal_16',
        'tanggal_17',
        'tanggal_18',
        'tanggal_19',
        'tanggal_20',
        'tanggal_21',
        'tanggal_22',
        'tanggal_23',
        'tanggal_24',
        'tanggal_25',
        'tanggal_26',
        'tanggal_27',
        'tanggal_28',
        'tanggal_29',
        'tanggal_30',
        'tanggal_31',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
