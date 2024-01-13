<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\DataPresensi;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresensiRequest;
use App\Http\Requests\UpdatePresensiRequest;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // Ambil semua data jadwal
        $jadwals = Jadwal::all();

   

        // Loop melalui setiap jadwal
        foreach ($jadwals as $jadwal) {
       
            // Ambil data presensi yang sesuai dengan jadwal
            $dataPresensi = DataPresensi::where([
            
            ])->get();
            for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, 1, now()->format('Y')); $day++) {
                $data = Jadwal::where("tanggal_$day", '!=', null)->pluck("tanggal_$day")->toArray();
            
                // Jika data ditemukan, ambil nilai pertama dari array
                $dayValue = !empty($data) ? $data[0] : null;
            
                // Menyimpan nilai ke dalam array $dayValues
                $dayValues["tanggal_$day"] = $dayValue;
               

                $tanggal="$day"."/12/2023";
                $presensi = DataPresensi::where('badgenumber', $jadwal->user_id)
                    ->where('eDate', $tanggal)
                    ->first();
                dd($presensi);

            }

            if ($dataPresensi) {
                // Ambil shift dari jadwal
                $shift = Shift::find($jadwal->shift_id);

                // Bandingkan data shift dengan data presensi
                if ($shift->kode_shift == $dataPresensi->kode_shift) {
                    // Sesuaikan logika atau tindakan yang perlu diambil
                    // Misalnya, Anda dapat memasukkan data presensi ke dalam tabel tertentu
                    // atau melakukan tindakan lain sesuai kebutuhan aplikasi Anda.
                    // Contoh:
                    // Presensi::create([
                    //     'user_id' => $jadwal->user_id,
                    //     'tanggal' => $jadwal->tanggal,
                    //     'shift_id' => $jadwal->shift_id,
                    //     'status' => 'Hadir', // Sesuaikan dengan logika presensi Anda
                    // ]);
                }
            }
        }

        // Tambahkan respons atau tindakan lain yang diperlukan
        return response()->json(['message' => 'Data presensi berhasil dimasukkan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresensiRequest $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        //
    }
}
