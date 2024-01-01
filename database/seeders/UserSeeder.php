<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role' => '1',
            'nama_karyawan' => 'Muhammad Ibnu',
            'email' => 'hrd@email.com',
            'jabatan' => 'HRD',
            'nik' => '1234567892',
            'password' => bcrypt('11111111'),
            'foto' => 'hrd.jpg',
            'alamat' => 'Alamat Manajer',
            'nomor_hp' => '08123456789',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Bagian HRD',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'role' => '2',
            'nama_karyawan' => 'Nama Manajer',
            'email' => 'manajer@email.com',
            'jabatan' => 'Manajer',
            'nik' => '123456789',
            'password' => bcrypt('password123'),
            'foto' => 'manajer.png',
            'alamat' => 'Alamat Manajer',
            'nomor_hp' => '08123456789',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Bagian Manajemen',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'role' => '2',
            'nama_karyawan' => 'Nama Kabag',
            'email' => 'kabag@email.com',
            'jabatan' => 'Kepala Bagian',
            'nik' => '123456781',
            'password' => bcrypt('22222222'),
            'foto' => 'manajer.png',
            'alamat' => 'Alamat Manajer',
            'nomor_hp' => '08123456789',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Bagian Kabag',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data Direktur RS
        DB::table('users')->insert([
            'role' => '2',
            'nama_karyawan' => 'Nama Direktur RS',
            'email' => 'direktur_rs@email.com',
            'jabatan' => 'Direktur RS',
            'nik' => '987654321',
            'password' => bcrypt('password456'),
            'foto' => 'direktur_rs.png',
            'alamat' => 'Alamat Direktur RS',
            'nomor_hp' => '08123456700',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Bagian RS',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        // Data Direktur PT
        DB::table('users')->insert([
            'role' => '2',
            'nama_karyawan' => 'Nama Direktur PT',
            'email' => 'direktur_pt@email.com',
            'jabatan' => 'Direktur PT',
            'nik' => '543216789',
            'password' => bcrypt('password789'),
            'foto' => 'direktur_pt.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Bagian PT',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('users')->insert([
            'role' => '2',
            'nama_karyawan' => 'Kepala Ruangan',
            'email' => 'karu@email.com',
            'jabatan' => 'Kepala Ruangan',
            'nik' => '543211243',
            'password' => bcrypt('password111'),
            'foto' => 'direktur_pt.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Bagian PT',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Muhammad Ibnu Prayogi',
            'email' => 'karyawan@email.com',
            'jabatan' => 'staff',
            'nik' => '2123312',
            'password' => bcrypt('password123'),
            'foto' => 'karyawan.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'HRD',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Marshall Ramdhani',
            'email' => 'karyawan2@email.com',
            'jabatan' => 'staff',
            'nik' => '21233122',
            'password' => bcrypt('password123'),
            'foto' => 'karyawan.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'HRD',
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }
}
