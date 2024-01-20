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
            'role' => '3',
            'nama_karyawan' => 'Jihad Wahyan',
            'email' => 'jihad@email.com',
            'jabatan' => 'Staff',
            'nik' => '123456789',
            'password' => bcrypt('11111111'),
            'foto' => 'manajer.png',
            'alamat' => 'Alamat Manajer',
            'nomor_hp' => '08123456789',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Fahmi Mutholib',
            'email' => 'kabag@email.com',
            'jabatan' => 'Staff',
            'nik' => '123456781',
            'password' => bcrypt('11111111'),
            'foto' => 'manajer.png',
            'alamat' => 'Alamat Manajer',
            'nomor_hp' => '08123456789',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data Direktur RS
        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Suheriyanto',
            'email' => 'heri@email.com',
            'jabatan' => 'Staff',
            'nik' => '987654321',
            'password' => bcrypt('11111111'),
            'foto' => 'direktur_rs.png',
            'alamat' => 'Alamat Direktur RS',
            'nomor_hp' => '08123456700',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data Direktur PT
        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Partio',
            'email' => 'partio@email.com',
            'jabatan' => 'Staff',
            'nik' => '543216789',
            'password' => bcrypt('11111111'),
            'foto' => 'direktur_pt.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Edi Trianto',
            'email' => 'edi@email.com',
            'jabatan' => 'Staff',
            'nik' => '543211243',
            'password' => bcrypt('11111111'),
            'foto' => 'direktur_pt.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Sudarmoko',
            'email' => 'moko@email.com',
            'jabatan' => 'Staff',
            'nik' => '2123312',
            'password' => bcrypt('11111111'),
            'foto' => 'karyawan.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Erwien',
            'email' => 'erwin@email.com',
            'jabatan' => 'staff',
            'nik' => '21233122',
            'password' => bcrypt('11111111'),
            'foto' => 'karyawan.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('users')->insert([
            'role' => '3',
            'nama_karyawan' => 'Wahyu Heri Kusuma',
            'email' => 'wahyu@email.com',
            'jabatan' => 'staff',
            'nik' => '123415431',
            'password' => bcrypt('11111111'),
            'foto' => 'karyawan.png',
            'alamat' => 'Alamat Direktur PT',
            'nomor_hp' => '08123456711',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('users')->insert([
            'role' => '2',
            'nama_karyawan' => 'Fahmi Mutholib',
            'email' => 'kabag1@email.com',
            'jabatan' => 'Kepala Bagian',
            'nik' => '1234567811',
            'password' => bcrypt('11111111'),
            'foto' => 'manajer.png',
            'alamat' => 'Alamat Manajer',
            'nomor_hp' => '08123456789',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'role' => '2',
            'nama_karyawan' => 'Sudarmoko',
            'email' => 'karu@email.com',
            'jabatan' => 'Kepala Ruangan',
            'nik' => '1234567811',
            'password' => bcrypt('11111111'),
            'foto' => 'manajer.png',
            'alamat' => 'Alamat Manajer',
            'nomor_hp' => '08123456789',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'Satpam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'role' => '1',
            'nama_karyawan' => 'Lilik Subowo',
            'email' => 'hrd@email.com',
            'jabatan' => 'Kepala Bagian',
            'nik' => '1234567892',
            'password' => bcrypt('11111111'),
            'foto' => 'hrd.jpg',
            'alamat' => 'Alamat Manajer',
            'nomor_hp' => '08123456789',
            'tanda_tangan' => 'signature.png',
            'nama_bagian' => 'HRD',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
    }
}
