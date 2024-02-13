<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use Knp\Snappy\Image;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\DataPresensi;
use App\Models\StatusJadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\StoreJadwalRequest;
use App\Http\Requests\UpdateJadwalRequest;

class KBJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('nama_bagian',auth()->user()->nama_bagian)->where('role',3)->get();
        $shifts = Shift::all();
        $jadwal = Jadwal::where('nama_bagian',auth()->user()->nama_bagian)->get();

        return View::make('kepalabagian.jadwal.index', compact('users', 'shifts','jadwal'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kepalabagian.jadwal.create');
        //
    }

   

// ...

public function store(Request $request)
{
    $jadwalData = $request->input('jadwal');
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    dd(intval(now()->format('m')));

    foreach ($jadwalData as $userId => $shifts) {
        // Inisialisasi $totalMinutes di sini untuk setiap user
        $totalMinutes = 0;
        $user=User::find($userId);

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
                        'nama_karyawan'=>$user->nama_karyawan,
                        'bulan' => intval($bulan),
                        'nama_bagian'=>auth()->user()->nama_bagian,
                        'tahun'=>$tahun
                    ],
                    [
                        "tanggal_$day" => $shiftId,
                    ],
                );
                $jadwal->jumlah_jam_kerja =  $totalMinutes;
                $jadwal->save();        

        }

    }

    $statusjadwal=StatusJadwal::where('bulan',intval($bulan))->where('tahun',intval($tahun))->where('nama_bagian',auth()->user()->nama_bagian)->first();
    if(!$statusjadwal){
        $statusjadwal= StatusJadwal::create([
            'nama_bagian'=>auth()->user()->nama_bagian,
            'bulan'=>intval($bulan),
            'tahun'=>$tahun,
            'status'=>'terbuka'
        ]); 
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

        $html = view('kepalabagian.jadwal.download', compact('users', 'jadwal','shifts'))->render();

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
    public function editjadwal($bulan,$tahun)
    {
        $currentDate = Carbon::now();
        if(intval($tahun)==$currentDate->year){
            $targetMonth=intval($bulan);
        }
        elseif(intval($tahun)>$currentDate->year){
            $targetMonth=intval($bulan)+12;
        } 
        if((($currentDate->day >10) && (($targetMonth-$currentDate->month) <=1)) || $targetMonth<=$currentDate->month ){
            $statusjadwal=StatusJadwal::where('bulan',intval($bulan))->where('tahun',$tahun)->first();
            if($statusjadwal==null ){
                $statusjadwal= StatusJadwal::create([
                    'nama_bagian'=>auth()->user()->nama_bagian,
                    'bulan'=>intval($bulan),
                    'tahun'=>intval($tahun),
                    'status'=>'terkunci'
                ]);
            }
            elseif($statusjadwal!=null && $statusjadwal->status=='terbuka'){ 
                return view('kepalabagian.jadwal.edit',compact('bulan','tahun'));
            }
            else{
            return redirect()->route('kbjadwal.index')->with('error','Penambahan Jadwal Gagal, Telah Melewati Batas Waktu Pengisian. Silahkan Hubungi Admin');
            }
        }
        else{
            return view('kepalabagian.jadwal.edit',compact('bulan','tahun'));
        }
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
