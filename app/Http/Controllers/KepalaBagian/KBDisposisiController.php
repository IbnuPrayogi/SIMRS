<?php

namespace App\Http\Controllers\KepalaBagian;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDisposisiRequest;
use App\Http\Requests\UpdateDisposisiRequest;

class KBDisposisiController extends Controller
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
    public function tambah($id,$jenis)
    {
        if($jenis == "surat keluar"){
            $surat = SuratKeluar::where('id', $id)->first();
        }
        else if($jenis == "surat masuk"){
            $surat = SuratMasuk::where('id', $id)->first();
        }

        return view('kepalabagian.disposisi.create',compact('surat','jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$id,$jenis)
    {

        if($jenis == "surat keluar"){
            $surat=SuratKeluar::find($id);
        }
        else if($jenis == "surat masuk"){
            $surat=SuratMasuk::find($id);
        }
        
        
        $request->validate([
            'deskripsi' => 'required|string',
        ]);
        $surat->status=$request->input('status');
        $surat->save();
  

        Disposisi::create([
            'id_surat'=> $surat->id,
            'nama_surat' => $surat->nama_surat,
            'status' => $surat->status,
            'deskripsi' => $request->input('deskripsi'),
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('kbsuratkeluar.index')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function showsurat($id,$nama)
    {
        $surats = Disposisi::where('id_surat', $id)->where('nama_surat',$nama)->get();
    
        return view('kepalabagian.disposisi.index',compact('surats'));
    }

 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi $disposisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisposisiRequest $request, Disposisi $disposisi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi $disposisi)
    {
        //
    }
}
