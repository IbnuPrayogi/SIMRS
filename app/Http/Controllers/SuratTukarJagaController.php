<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use App\Models\SuratTukarJaga;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreSuratTukarJagaRequest;
use App\Http\Requests\UpdateSuratTukarJagaRequest;


class SuratTukarJagaController extends Controller
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
    public function create()
    {
        $karyawan=User::where('nama_bagian',auth()->user()->nama_bagian)->get();

        return view("karyawan.SuratTukarJaga.create",compact('karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'mimes:pdf,doc,docx|max:5120',
        ]);
       

        // $location1 = 'assets/suratTukarJaga/';

        $suratTukarJaga = SuratTukarJaga::create([
            'nama_pengaju' => auth()->user()->nama_karyawan,
            'nama_target' => $request->nama_target,
            'jadwal_asli' => $request->jadwal_asli,
            'jadwal_dirubah' => $request->jadwal_dirubah,
            'target_tukar_jaga' => $request->target_tukar_jaga,
            'keterangan' => $request->keterangan,
            'tanda_tangan'=>auth()->user()->tanda_tangan,
            'status' => "Termohon",
        ]);

      
        $suratTukarJaga->nama_surat ="Surat Tukar Jaga ".auth()->user()->nama_karyawan.$suratTukarJaga->id;

        $suratTukarJaga->save();
        $Convertpdf = PDF::loadView('karyawan.SuratTukarJaga.templatetukarjaga', compact('suratTukarJaga'));
        $file_name = $suratTukarJaga->nama_surat . '.pdf';
        $file_path = storage_path('../public/assets/SuratTukarJaga/') . $file_name;
        $Convertpdf->save($file_path);
        $suratTukarJaga->file = $file_name;
        $suratTukarJaga->save();

        Disposisi::create([
            'id_surat'=> $suratTukarJaga->id,
            'nama_surat' => $suratTukarJaga->nama_surat,
            'status' => $suratTukarJaga->status,
            'deskripsi' => "Surat Telah diajukan oleh ".$suratTukarJaga->nama_pengaju,
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        Session::flash('success', 'Data surat Berhasil Ditambahkan');
        return redirect()->route('surattukarjaga.create')->with('success', 'surat berhasil ditambahkan.');
    }

    public function priview(Request $request, $id)
    {
        $suratTukarJaga = SuratTukarJaga::where('id', $id)->first();
        return view('admin.DaftarPermohonanTukarJaga.priview', compact('suratTukarJaga'));
    }
    public function Sign($id,$jenis)
    {

        $suratTukarJaga = SuratTukarJaga::where('id', $id)->first();
        if($jenis == 'Kepala Ruangan'){
            $suratTukarJaga->kepala_ruangan = auth()->user()->tanda_tangan;
            $suratTukarJaga->status= 'Kepala Bagian';
            $suratTukarJaga->nama_kepala_ruangan=auth()->user()->nama_karyawan;
        }
        else if($jenis == 'Kepala Bagian'){
            $suratTukarJaga->kepala_bagian = auth()->user()->tanda_tangan;
            $suratTukarJaga->status= 'disetujui';
            $suratTukarJaga->nama_kepala_bagian=auth()->user()->nama_karyawan;
        }



        $suratTukarJaga->save();

        $pdf = PDF::loadView('admin.DaftarPermohonanTukarJaga.signature', compact('suratTukarJaga'));
        $file_name = $suratTukarJaga->file;
        $file_path = storage_path('../public/assets/SuratTukarJaga/') . $file_name;

        $FileToDelete = public_path('../public/assets/SuratTukarJaga/') . $suratTukarJaga->file;

        if (File::exists($FileToDelete)) {
            File::delete($FileToDelete);
            $pdf->save($file_path);
        } else {
            $pdf->save($file_path);
            // return 'Filer not found';
        }

        Disposisi::create([
            'id_surat'=> $suratTukarJaga->id,
            'nama_surat' => $suratTukarJaga->nama_surat,
            'status' => $suratTukarJaga->status,
            'deskripsi' => "Surat Telah disetujui ".$jenis,
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);


        // Redirect ke halaman SuratCuti.show dengan menambahkan ID baru
        return redirect()->route('DaftarPermohonan.indexTukarJaga')
            ->with('success', 'Data berhasil disimpan!');
    }

    public function permintaantukarjaga(){
        $surattukarjaga= SuratTukarJaga::where('target_tukar_jaga',auth()->user()->nama_karyawan)->get();
        return view('karyawan.permintaantukarjaga',compact('surattukarjaga'));
    }

    public function setujui($id)
    {

        $suratTukarJaga = SuratTukarJaga::where('id', $id)->first();
      
            $suratTukarJaga->termohon = auth()->user()->tanda_tangan;
            $suratTukarJaga->status= 'Kepala Ruangan';


        $suratTukarJaga->save();

        $pdf = PDF::loadView('admin.DaftarPermohonanTukarJaga.signature', compact('suratTukarJaga'));
        $file_name = $suratTukarJaga->file;
        $file_path = storage_path('../public/assets/SuratTukarJaga/') . $file_name;

        $FileToDelete = public_path('../public/assets/SuratTukarJaga/') . $suratTukarJaga->file;

        if (File::exists($FileToDelete)) {
            File::delete($FileToDelete);
            $pdf->save($file_path);
        } 
        else {
            $pdf->save($file_path);
            // return 'Filer not found';
        }

        Disposisi::create([
            'id_surat'=> $suratTukarJaga->id,
            'nama_surat' => $suratTukarJaga->nama_surat,
            'status' => $suratTukarJaga->status,
            'deskripsi' => "Surat Telah disetujui Termohon",
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);
        // Redirect ke halaman SuratCuti.show dengan menambahkan ID baru
        return redirect()->route('tukarjaga.permintaan')
            ->with('success', 'Data berhasil disimpan!');
    }

    public function tolak($id){
        $suratTukarJaga = SuratTukarJaga::where('id', $id)->first();

        $suratTukarJaga->status= 'ditolak';

        $suratTukarJaga->save();

        Disposisi::create([
            'id_surat'=> $suratTukarJaga->id,
            'nama_surat' => $suratTukarJaga->nama_surat,
            'status' => $suratTukarJaga->status,
            'deskripsi' => "Surat Telah Ditolak oleh Termohon",
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        return redirect()->route('tukarjaga.permintaan')
            ->with('success', 'Data berhasil disimpan!');
    }


    public function downloadSuratTukarJaga(Request $request, $id, $file)
    {
        $suratTukarJaga = SuratTukarJaga::find($id);
        if (!$suratTukarJaga) {
            abort(404);
        }
        $file_path = storage_path('../public/assets/suratTukarJaga/') . $suratTukarJaga->file;

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

    public function TolakTukarJaga($id,$jenis){
        $suratTukarJaga = SuratTukarJaga::where('id', $id)->first();

        $suratTukarJaga->status= 'ditolak';

        $suratTukarJaga->save();

        Disposisi::create([
            'id_surat'=> $suratTukarJaga->id,
            'nama_surat' => $suratTukarJaga->nama_surat,
            'status' => $suratTukarJaga->status,
            'deskripsi' => "Surat Telah Ditolak oleh ".$jenis,
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        return redirect()->route('DaftarPermohonan.indexTukarJaga')
            ->with('success', 'Permohonan Tukar Jaga Ditolak!');
    }
   
    public function show(SuratTukarJaga $suratTukarJaga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratTukarJaga $suratTukarJaga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuratTukarJagaRequest $request, SuratTukarJaga $suratTukarJaga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratTukarJaga $suratTukarJaga)
    {
        //
    }
}
