<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Disposisi;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreSuratKeluarRequest;
use App\Http\Requests\UpdateSuratKeluarRequest;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratkeluar = SuratKeluar::all();
        return view("admin.suratkeluar.index", compact("suratkeluar"));
    }
    public function create()
    {
        // $suratKeluar = SuratKeluar::all();
        return view("admin.suratkeluar.create");
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $file1 = $validatedData['file'];
        $filename1 = $file1->getClientOriginalName();
        $location1 = 'assets/suratkeluar/';

        $surat=SuratKeluar::create([
            'nama_surat' => $request->nama_surat,
            'kategori_surat' => $request->kategori_surat,
            'tanggal_dibuat' => $request->tanggal_dibuat,
            'tujuan_surat' => $request->tujuan_surat,
            'kode_surat' => $request->kode_surat,
            'pembuat_surat' => auth()->user()->nama_karyawan,
            'jenis_surat' => 'Upload',
            'file' => $filename1,
            'status'=>"Kepala Bagian",
        ]);

        Disposisi::create([
            'id_surat'=> $surat->id,
            'nama_surat' => $surat->nama_surat,
            'status' => $surat->status,
            'deskripsi' => "Surat Telah diajukan oleh HRD",
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        $file1->move(public_path($location1), $filename1);
        Session::flash('success', 'Data surat Berhasil Ditambahkan');
        return redirect()->route('suratkeluar.index')->with('success', 'surat berhasil ditambahkan.');
    }
    
    public function show(SuratKeluar $suratKeluar)
    {
        //
    }
    public function edit($id)
    {
        $suratkeluarr = SuratKeluar::where('id', $id)->first();
        return view('admin.suratkeluar.edit', compact(['suratkeluarr']));
    }
    public function update(Request $request, $id)
    {

        $suratkeluarr = SuratKeluar::where('id', $id)->first();
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
        return redirect()->route('suratkeluar.index')->with('success', 'Data Surat berhasil diupdate.');

    }
    public function destroy($id)
    {
        $data = SuratKeluar::where('id', $id)->first();
        $data->delete();
        Session::flash('success', 'Surat Berhasil Dihapus');
        return redirect()->back();
    }
    public function downloadSurat(Request $request, $id, $file)
    {
        $suratkeluarr = SuratKeluar::find($id);
        if (!$suratkeluarr) {
            abort(404);
        }
        $file_path = storage_path('../public/assets/suratkeluar/') . $suratkeluarr->file;

        // Tentukan nama file yang akan di-download
        $file = $suratkeluarr->file;
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

        $mime_types = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $mime_type = $mime_types[$extension] ?? 'application/octet-stream';
        return response()->download($file_path, $file, ['Content-Type' => $mime_type]);
    }
    public function template(){
        return view("admin.suratkeluar.formtemplate");
    }


}
