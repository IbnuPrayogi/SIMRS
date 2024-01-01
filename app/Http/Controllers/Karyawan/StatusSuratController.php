<?php

namespace App\Http\Controllers\Karyawan;

use App\Models\User;
use App\Models\Disposisi;
use App\Models\SuratCuti;
use App\Models\SuratIzin;
use Illuminate\Http\Request;
use App\Models\SuratTukarJaga;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class StatusSuratController extends Controller
{
    public function statuscuti($id){
        $user= User::where('id',$id)->first();
        
        $suratcuti=SuratCuti::where('nama_pengaju',$user->nama_karyawan)->get();
       
        return view('karyawan.statuscutimobile',compact('user','suratcuti'));
    }

    public function downloadSuratCuti(Request $request, $id, $file)
    {
        $suratCuti = SuratCuti::find($id);
        if (!$suratCuti) {
            abort(404);
        }
        $file_path = storage_path('../public/assets/suratCuti/') . $suratCuti->file;

        // Tentukan nama file yang akan di-download
        $file = $suratCuti->file;
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

        $mime_types = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $mime_type = $mime_types[$extension] ?? 'application/octet-stream';
        return response()->download($file_path, $file, ['Content-Type' => $mime_type]);
    }

    public function destroyCuti($id)
    {
        $surat = SuratCuti::findOrFail($id);
       

        $FileToDelete = public_path('../public/assets/suratCuti/') . $surat->file;
        if (File::exists($FileToDelete)) {
            File::delete($FileToDelete);
        }

        $surat->delete();
        return redirect()->back();
    }

    public function statusizin($id){
        $user= User::where('id',$id)->first();
        
        $suratizin=SuratIzin::where('nama_pengaju',$user->nama_karyawan)->get();
       
        return view('karyawan.statusizinmobile',compact('user','suratizin'));
    }

    public function downloadSuratIzin(Request $request, $id, $file)
    {
        $suratIzin = SuratIzin::find($id);
        if (!$suratIzin) {
            abort(404);
        }
        $file_path = storage_path('../public/assets/suratIzin/') . $suratIzin->file;

        // Tentukan nama file yang akan di-download
        $file = $suratIzin->file;
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

        $mime_types = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $mime_type = $mime_types[$extension] ?? 'application/octet-stream';
        return response()->download($file_path, $file, ['Content-Type' => $mime_type]);
    }

    public function destroyIzin($id)
    {
        $surat = SuratIzin::findOrFail($id);
       

        $FileToDelete = public_path('../public/assets/suratIzin/') . $surat->file;
        if (File::exists($FileToDelete)) {
            File::delete($FileToDelete);
        }

        $surat->delete();
        return redirect()->back();
    }

    public function statustukarjaga($id){
        $user= User::where('id',$id)->first();
        
        $surattukarjaga=SuratTukarJaga::where('nama_pengaju',$user->nama_karyawan)->get();
       
        return view('karyawan.statustukarjagamobile',compact('user','surattukarjaga'));
    }

    public function downloadSuratTukarJaga(Request $request, $id, $file)
    {
        $suratTukarJaga = SuratTukarJaga::find($id);
        if (!$suratTukarJaga) {
            abort(404);
        }
        $file_path = storage_path('../public/assets/SuratTukarJaga/') . $suratTukarJaga->file;

        // Tentukan nama file yang akan di-download
        $file = $suratTukarJaga->file;
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

        $mime_types = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $mime_type = $mime_types[$extension] ?? 'application/octet-stream';
        return response()->download($file_path, $file, ['Content-Type' => $mime_type]);
    }

    public function destroyTukarJaga($id)
    {
        $surat = SuratTukarJaga::findOrFail($id);
       

        $FileToDelete = public_path('../public/assets/suratTukarJaga/') . $surat->file;
        if (File::exists($FileToDelete)) {
            File::delete($FileToDelete);
        }

        $surat->delete();
        return redirect()->back();
    }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposisi $disposisi)
    {
        //
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
    public function update(Request $request, Disposisi $disposisi)
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
