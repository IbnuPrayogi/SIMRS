<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\StatusJadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStatusJadwalRequest;
use App\Http\Requests\UpdateStatusJadwalRequest;

class StatusJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bagians=Bagian::all();
        
        $selectedMonth = $request->query('selectedMonth', now()->format('m'));
        $selectedYear = $request->query('selectedYear', now()->format('Y'));
        $statusjadwals=StatusJadwal::where('bulan', $selectedMonth)->where('tahun',$selectedYear)->get();
        return view('admin.statusjadwal.index',compact('bagians','statusjadwals','selectedMonth','selectedYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function kunci(Request $request)
    {
      
        $statusjadwal=StatusJadwal::where('bulan', intval($request->input('bulan')))->where('tahun',$request->input('tahun'))->where('nama_bagian',$request->input('bagian'))->first();
        if($statusjadwal){
            $statusjadwal->status='terkunci';
            $statusjadwal->save();
        }
        else{
            $statusjadwal= StatusJadwal::create([
                'nama_bagian'=>$request->input('bagian'),
                'bulan'=>intval($request->input('bulan')),
                'tahun'=>intval($request->input('tahun')),
                'status'=>'terkunci'
            ]);
        }
        $bagians=Bagian::all();
        $selectedMonth = intval($request->input('bulan'));
        $selectedYear = intval($request->input('tahun'));
        $statusjadwals=StatusJadwal::where('bulan', $selectedMonth)->where('tahun',$selectedYear)->get();

        return redirect()->route('statusjadwal.index',compact('bagians','statusjadwals','selectedMonth','selectedYear'))->with('success','Data Jadwal Berhasil Dikunci');
    }

    public function buka(Request $request)
    {
        $statusjadwal=StatusJadwal::where('bulan', intval($request->input('bulan')))->where('tahun',$request->input('tahun'))->where('nama_bagian',$request->input('bagian'))->first();
 
        $statusjadwal->status='terbuka';
        $statusjadwal->save();
        

        $bagians=Bagian::all();
        $selectedMonth = intval($request->input('bulan'));
        $selectedYear = intval($request->input('tahun'));
        $statusjadwals=StatusJadwal::where('bulan', $selectedMonth)->where('tahun',$selectedYear)->get();

        return redirect()->route('statusjadwal.index',compact('bagians','statusjadwals','selectedMonth','selectedYear'))->with('success','Data Jadwal Berhasil Buka');
    }

    public function kuncisemua(Request $request)
    {
        $bagians=Bagian::all();
        foreach ($bagians as $bagian) {
            $statusjadwal=StatusJadwal::where('bulan', intval($request->input('bulan')))->where('tahun',$request->input('tahun'))->where('nama_bagian',$bagian->nama_bagian)->first();
            if($statusjadwal){
                $statusjadwal->status='terkunci';
                $statusjadwal->save();
            }
            else{
                $statusjadwal= StatusJadwal::create([
                    'nama_bagian'=>$bagian->nama_bagian,
                    'bulan'=>intval($request->input('bulan')),
                    'tahun'=>intval($request->input('tahun')),
                    'status'=>'terkunci'
                ]);
            }
        }

        $bagians=Bagian::all();
        $selectedMonth = intval($request->input('bulan'));
        $selectedYear = intval($request->input('tahun'));
        $statusjadwals=StatusJadwal::where('bulan', $selectedMonth)->where('tahun',$selectedYear)->get();

        return redirect()->route('statusjadwal.index',compact('bagians','statusjadwals','selectedMonth','selectedYear'))->with('success','Data Jadwal Berhasil Dikunci');
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusJadwalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusJadwal $statusJadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusJadwal $statusJadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusJadwalRequest $request, StatusJadwal $statusJadwal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusJadwal $statusJadwal)
    {
        //
    }
}
