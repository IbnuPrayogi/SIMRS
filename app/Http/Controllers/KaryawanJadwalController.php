<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shift;
use App\Models\Bagian;
use App\Models\Jadwal;
use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class KaryawanJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $selectedMonth = $request->query('selectedMonth', now()->format('m'));
        $selectedYear = $request->query('selectedYear', now()->format('Y'));
        $date=$selectedMonth."/".$selectedYear;
        $shift = Shift::where('bagian',auth()->user()->nama_bagian)->get();
        $jadwal = Jadwal::where('bulan', $selectedMonth)->where('tahun',$selectedYear)->where('nama_karyawan',auth()->user()->nama_karyawan)->first();
        $users = User::where('nama_bagian',auth()->user()->nama_bagian)->where('role',3)->get();
        $shifts = Shift::all();
        $jadwals = Jadwal::where('nama_bagian',auth()->user()->nama_bagian)->get();


        return View::make('karyawan.jadwal', compact('jadwal','shift','users','shifts','jadwals'), [
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
        ]);
        
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
