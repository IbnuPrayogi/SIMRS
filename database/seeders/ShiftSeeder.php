<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shifts')->insert([
            [
                'nama_shift' => 'Pagi',
                'kode_shift' => 'P',
                'bagian' => 'HRD',
                'cin1' => '07:00:00',
                'cout1' => '15:00:00',
                'cin2' => null,
                'cout2' => null,
                'lama_waktu' => '08:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_shift' => 'Siang',
                'kode_shift' => 'S',
                'bagian' => 'HRD',
                'cin1' => '12:00:00',
                'cout1' => '20:00:00',
                'cin2' => null,
                'cout2' => null,
                'lama_waktu' => '08:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_shift' => 'Malam',
                'kode_shift' => 'M',
                'bagian' => 'HRD',
                'cin1' => '20:00:00',
                'cout1' => '04:00:00',
                'cin2' => null,
                'cout2' => null,
                'lama_waktu' => '08:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
