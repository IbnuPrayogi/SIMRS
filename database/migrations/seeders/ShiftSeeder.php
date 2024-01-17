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
                'cout1' => '14:00:00',
                'cin2' => null,
                'cout2' => null,
                'lama_waktu' => '07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_shift' => 'Siang',
                'kode_shift' => 'S',
                'bagian' => 'HRD',
                'cin1' => '14:00:00',
                'cout1' => '21:00:00',
                'cin2' => null,
                'cout2' => null,
                'lama_waktu' => '07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_shift' => 'Malam',
                'kode_shift' => 'M',
                'bagian' => 'HRD',
                'cin1' => '21:00:00',
                'cout1' => '07:00:00',
                'cin2' => null,
                'cout2' => null,
                'lama_waktu' => '10:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_shift' => 'Pagi Malam',
                'kode_shift' => 'PM',
                'bagian' => 'HRD',
                'cin1' => '07:00:00',
                'cout1' => '14:00:00',
                'cin2' => '21:00:00',
                'cout2' => '07:00:00',
                'lama_waktu' => '17:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_shift' => 'Libur',
                'kode_shift' => 'L',
                'bagian' => 'HRD',
                'cin1' => '00:00:00',
                'cout1' => '00:00:00',
                'cin2' => '00:00:00',
                'cout2' => '00:00:00',
                'lama_waktu' => '00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
