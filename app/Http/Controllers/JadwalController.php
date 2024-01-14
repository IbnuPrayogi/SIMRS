<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use Knp\Snappy\Image;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\DataPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $jadwal = Jadwal::all();

        return View::make('admin.jadwal.index', compact('users', 'shifts','jadwal'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jadwal.create');
        //
    }

   

// ...

public function store(Request $request)
{
    $jadwalData = $request->input('jadwal');
    $bulan = $request->input('bulan');

    foreach ($jadwalData as $userId => $shifts) {
        // Inisialisasi $totalMinutes di sini untuk setiap user
        $totalMinutes = 0;

        foreach ($shifts as $day => $shiftId) {
            // Pastikan $day memiliki nilai yang valid sebelum digunakan
                $shift = Shift::find($shiftId);

                if ($shift) {
                    list($hours, $minutes, $second) = explode(':', $shift->lama_waktu);
                    $totalMinutes += $hours * 60 + $minutes;
                }

                // Update or add Jadwal
                $jadwal = Jadwal::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'bulan' => $bulan,
                    ],
                    [
                        "tanggal_$day" => $shiftId,
                    ],
                );
                $jadwal->jumlah_jam_kerja =  $totalMinutes;
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

    public function importTable(Request $request)
    {
        $sqlFile = $request->file('sql_file');

        // Validasi file dan format SQL jika diperlukan

        try {
            $sqlContent = file_get_contents($sqlFile->getRealPath());
            // Eksekusi pernyataan SQL
            DB::unprepared($sqlContent);
            return redirect('/import-sql-table')->with('success', 'Table imported successfully');
        } catch (\Exception $e) {
            return redirect('/import-sql-table')->with('error', 'Error importing table: ' . $e->getMessage());
        }
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
