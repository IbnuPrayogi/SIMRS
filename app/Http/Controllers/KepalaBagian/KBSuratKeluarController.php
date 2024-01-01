<?php

namespace App\Http\Controllers\KepalaBagian;

use PDF;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreSuratKeluarRequest;
use App\Http\Requests\UpdateSuratKeluarRequest;

class KBSuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suratkeluar = SuratKeluar::all();
        return view("kepalabagian.suratkeluar.index", compact("suratkeluar"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $suratKeluar = SuratKeluar::all();
        return view("admin.SuratKeluar.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    

    /**
     * Display the specified resource.
     */
    public function show(SuratKeluar $suratKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suratkeluarr = SuratKeluar::where('id', $id)->first();
        return view('admin.SuratKeluar.edit', compact(['suratkeluarr']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $suratkeluarr = SuratKeluar::where('id', $id)->first();
        // dd($suratkeluarr);
        $suratkeluarr->nama_surat = $request->input('nama_surat');
        $suratkeluarr->kategori_surat = $request->input('kategori_surat');
        $suratkeluarr->tanggal_dibuat = $request->input('tanggal_dibuat');
        $suratkeluarr->jenis_surat = $request->input('jenis_surat');
        $suratkeluarr->tujuan_surat = $request->input('tujuan_surat');
        $suratkeluarr->kode_surat = $request->input('kode_surat');

        $suratkeluarr->save();

        $title = "Edit Surat";
        Session::flash('success', 'Data Surat Berhasil DiUbah');
        $suratkeluarr = SuratKeluar::all();
        // return redirect()->route('surat.index')->with('success', 'User berhasil diupdate.');
        return redirect()->route('suratkeluar.index')->with('success', 'Data Surat berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = SuratKeluar::where('id', $id)->first();
        $data->delete();
        Session::flash('success', 'Surat Berhasil Dihapus');
        return redirect()->back();
    }
    public function Cetak(Request $request, $id){
        $data = SuratKeluar::where('id', $id)->first();
        // $filepdf = $suratkeluar ->$file;
        // $pdf = SuratKeluar::loadView('cetak_surat',['file' => $SuratKeluar ->$file ]);
        // return $pdf->stream('cetak_surat.pdf');
    }
    public function downloadSurat(Request $request, $id, $file)
    {

        $suratkeluarr = SuratKeluar::find($id);

        if (!$suratkeluarr) {
            abort(404);
        }
        $file_path = storage_path('../public/assets/suratkeluar/') . $suratkeluarr->file;
        // dd($file_path);


        // Tentukan nama file yang akan di-download
        $file = $suratkeluarr->file;
        // dd($file_path);
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

        // Map ekstensi ke tipe MIME (tambahkan ekstensi yang diperlukan)
        $mime_types = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        // Tentukan tipe MIME berdasarkan ekstensi file
        $mime_type = $mime_types[$extension] ?? 'application/octet-stream';

        // Return response untuk download file
        return response()->download($file_path, $file, ['Content-Type' => $mime_type]);
    }
    public function template(){
        return view("admin.SuratKeluar.formtemplate");
    }

    public function setujuisurat($id){
   
        $data = SuratKeluar::find($id);

     
        $data->status = "disetujui";
        $data->save();

        return redirect()->back();
    }

    public function tolaksurat($id){
    
        $data = SuratKeluar::find($id);

    
        $data->status = "ditolak";
        $data->save();

        return redirect()->back();
    }

    public function approve($id){
    

        $suratkeluarr = SuratKeluar::find($id);
        return view("admin.SuratKeluar.approve", compact("suratkeluarr"));

    }

    public function reject($id){
    

        $suratkeluarr = SuratKeluar::find($id);
        return view("admin.SuratKeluar.reject", compact("suratkeluarr"));

    }

    public function restore($id){
    

        $suratkeluarr = SuratKeluar::find($id);
        return view("admin.SuratKeluar.restore", compact("suratkeluarr"));

    }
}
