<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratCuti;
use App\Models\Disposisi;
use App\Http\Requests\StoreSuratCutiRequest;
use App\Http\Requests\UpdateSuratCutiRequest;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;




class SuratCutiController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        return view("karyawan.SuratCuti.create");
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'file' => 'mimes:pdf,doc,docx|max:5120',
        ]);

        $location1 = 'assets/suratCuti/';

        $suratCuti = SuratCuti::create([
            'nama_pengaju' => auth()->user()->nama_karyawan,
            'bagian' => $request->bagian,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alamat' => $request->alamat,
            'jabatan' => $request->jabatan,
            'keterangan' => $request->keterangan,
            'tanda_tangan'=>auth()->user()->tanda_tangan,
            'status' => "Kepala Bagian",
        ]);

        $suratCuti->nama_surat ="Surat Cuti ".auth()->user()->nama_karyawan.$suratCuti->id;

        $suratCuti->save();


        $pdf = PDF::loadView('karyawan.SuratCuti.templatecuti', compact('suratCuti'));
        $file_name = $suratCuti->nama_surat . '.pdf';
        $file_path = storage_path('../public/assets/suratCuti/') . $file_name;
        $pdf->save($file_path);
        $suratCuti->file = $file_name;
        $suratCuti->save();

        Disposisi::create([
            'id_surat'=> $suratCuti->id,
            'nama_surat' => $suratCuti->nama_surat,
            'status' => $suratCuti->status,
            'deskripsi' => "Surat Telah diajukan oleh ".$suratCuti->nama_pengaju,
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        Session::flash('success', 'Data surat Berhasil Ditambahkan');
        return redirect()->route('suratcuti.create')->with('success', 'surat berhasil ditambahkan.');
    }

    public function priview(Request $request, $id)
    {
        $suratCuti = SuratCuti::where('id', $id)->first();
        // $pdf = PDF::loadView('admin.TemplateSK.signature', compact('templateSK'));
        return view('admin.DaftarPermohonanCuti.priviewCuti', compact('suratCuti'));
    }
    public function Sign($id)
    {
        $suratCuti = SuratCuti::where('id', $id)->first();
        $suratCuti->kepala_bagian = auth()->user()->tanda_tangan;
        $suratCuti->nama_kepala_bagian = auth()->user()->nama_karyawan;
        $suratCuti->save();

        $pdf = PDF::loadView('admin.DaftarPermohonanCuti.signature', compact('suratCuti'));
        $file_name = 'ACC_' . $suratCuti->file; // Assuming you want to prepend 'ACC_' to the existing file name
        $file_path = public_path('../public/assets/suratCuti/') . $file_name;

        $FileToDelete = public_path('../public/assets/suratCuti/') . $suratCuti->file;

        if (File::exists($FileToDelete)) {
            File::delete($FileToDelete);
            $pdf->save($file_path);
        } else {
            $pdf->save($file_path);
        }

        // Update the file attribute in the database
        $suratCuti->file = $file_name;
        $suratCuti->status = "disetujui";
        $suratCuti->save();

        Disposisi::create([
            'id_surat'=> $suratCuti->id,
            'nama_surat' => $suratCuti->nama_surat,
            'status' => 'disetujui',
            'deskripsi' => "Surat Telah disetujui ",
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        // Redirect ke halaman suratIzin.show dengan menambahkan ID baru
        return redirect()->route('DaftarPermohonan.indexCuti')
            ->with('success', 'Data berhasil disimpan!');
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

    public function Tolak($id){
        $suratCuti = SuratCuti::where('id', $id)->first();

        $suratCuti->status= 'ditolak';

        $suratCuti->save();

        Disposisi::create([
            'id_surat'=> $suratCuti->id,
            'nama_surat' => $suratCuti->nama_surat,
            'status' => $suratCuti->status,
            'deskripsi' => "Surat Telah Ditolak oleh Kepala Bagian",
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        return redirect()->route('DaftarPermohonan.indexCuti')
            ->with('success', 'Permohonan Cuti Ditolak!');
    }
    public function show(SuratCuti $suratCuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratCuti $suratCuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuratCutiRequest $request, SuratCuti $suratCuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratCuti $suratCuti)
    {
        //
    }
}
