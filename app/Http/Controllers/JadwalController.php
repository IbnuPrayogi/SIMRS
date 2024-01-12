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
        $jadwal = Jadwal::where('bulan', now()->month)->get();

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

    public function importTable(Request $request)
    {
        $sqlFile = $request->file('sql_file');

        // Validasi file dan format SQL jika diperlukan

        try {
            $sqlContent = file_get_contents($sqlFile->getRealPath());
            // Eksekusi pernyataan SQL
            DB::unprepared($sqlContent);

            $inoutdataRecords = DataPresensi::all();

            // Iterasi setiap record dan masukkan ke dalam tabel presensi
            foreach ($inoutdataRecords as $inoutdataRecord) {
          
                $stimeArray = explode(' ', $inoutdataRecord->stime);

                $uniqueStimeArray = array_values(array_unique($stimeArray));
                dd(count($uniqueStimeArray));
            
                if(count($uniqueStimeArray)>2){
                    $cout1=$uniqueStimeArray[1];
                    $cin2 = $uniqueStimeArray[1];
                    $cout2= $uniqueStimeArray[2];
                }
                elseif(count($uniqueStimeArray)==1){
                    $cout1=null;
                    $cin2 = null;
                    $cout2= null;
                }
                elseif(count($uniqueStimeArray)==0){
                    $cin1=null;
                    $cout1=null;
                    $cin2 = null;
                    $cout2= null;
                }
                else {
                    $cin2 = NULL;
                    $cout2= NULL;
                }
                
                Presensi::create([
                    'id_karyawan' => $inoutdataRecord->badgenumber,
                    'nama_karyawan' => $inoutdataRecord->username,
                    'nama_bagian' => $inoutdataRecord->deptname,
                    'tanggal' => Carbon::createFromFormat('d/m/Y', $inoutdataRecord->eDate)->format('Y-m-d'),
                    'cin1' => Carbon::parse($uniqueStimeArray[0])->format('H:i:s'),
                    'cout1' => Carbon::parse($cout1)->format('H:i:s'),
                    'cin2' => Carbon::parse($cin2)->format('H:i:s'),
                    'cout2' => Carbon::parse($cout2)->format('H:i:s'),
          
                    // Tambahkan atribut lain sesuai kebutuhan
                ]);
                array_splice($uniqueStimeArray, 0);
            }

         
            

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
