<?php

namespace App\Http\Controllers;

use Knp\Snappy\Image;
use App\Models\User;
use App\Models\Shift;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\StoreJadwalRequest;
use App\Http\Requests\UpdateJadwalRequest;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $shifts = Shift::all();
        $jadwal = Jadwal::where('bulan', now()->month)->get();

        return View::make('admin.jadwal.index', compact('users', 'shifts','jadwal'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

   

// ...

public function store(Request $request)
{
    $jadwalData = $request->input('jadwal');
    $bulan = $request->input('bulan');

    foreach ($jadwalData as $userId => $shifts) {
        $totalMinutes = 0;

        foreach ($shifts as $day => $shiftId) {
            $shift = Shift::find($shiftId);

            if ($shift) {
                list($hours, $minutes,$second) = explode(':', $shift->lama_waktu);
                $totalMinutes += $hours * 60 + $minutes;
            }
            
        

        // Update or add Jadwal
        $jadwal=Jadwal::updateOrCreate(
            [
                'user_id' => $userId,
                'bulan' => $bulan,
          
            ],
            [
                "tanggal_$day" => $shiftId,
            ],
        );

        $jadwal->jumlah_jam_kerja=$totalMinutes;
        $jadwal->save();
    }

    }

    // Additional logic if needed

    return redirect()->back()->with('success', 'Jadwal berhasil disimpan.');
}


    /**
     * Store a newly created resource in storage.
     */
 

    public function download()
    {
        $users = User::all();
        $shifts = Shift::all();
        $jadwal = Jadwal::where('bulan', now()->month)->get();

        $html = view('admin.jadwal.download', compact('users', 'jadwal','shifts'))->render();

        $image = new Image();
        $image->setOptions(['encoding' => 'utf-8']);

        $imageContent = $image->getOutputFromHtml($html);

        return response($imageContent)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename=jadwal_karyawan.png');
    
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
    public function editjadwal($bulan)
    {
        return view('admin.jadwal.edit',compact('bulan'));
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
