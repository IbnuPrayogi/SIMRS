<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJadwalRequest;
use App\Http\Requests\UpdateJadwalRequest;

class JadwalController extends Controller
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
    public function store(Request $request)
    {
        $jadwalData = $request->input('jadwal');
        $bulan = $request->input('bulan');
    
        foreach ($jadwalData as $userId => $shifts) {
            foreach ($shifts as $day => $shiftId) {
                Jadwal::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'bulan' => $bulan,
                    ],
                    [
                        "tanggal_$day" => $shiftId,
                    ]
                );
            }
        }
    
        // Tambahkan logika lainnya jika diperlukan
    
        return redirect()->back()->with('success', 'Jadwal berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJadwalRequest $request, Jadwal $jadwal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
