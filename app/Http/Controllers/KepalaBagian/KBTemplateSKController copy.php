<?php

namespace App\Http\Controllers\KepalaBagian;

use App\Models\TemplateSK;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTemplateSKRequest;
use App\Http\Requests\UpdateTemplateSKRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;



class KBTemplateSKController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
        return view("admin.TemplateSK.create");
    }

    // public function store(Request $request)
    // {

    //     $templateSK = TemplateSK::create([
    //         'perihal' => $request->perihal,
    //         'hari_tanggal' => $request->hari_tanggal,
    //         'waktu' => $request->waktu,
    //         'tempat' => $request->tempat,
    //         'tanggal_surat' => $request->tanggal_surat,
    //         'pembuat_surat' => 1,
    //     ]);

    //     // Redirect ke halaman templateSK.show dengan menambahkan ID baru
    //     return redirect()->route('templateSK.show', ['id' => $templateSK->id])
    //         ->with('success', 'Data berhasil disimpan!');
    // }

    // public function template($id)
    // {
    //     $templateSK = TemplateSK::find($id);
    //     return view('admin.TemplateSK.template', compact('templateSK'));
    // }


    public function storeSKForm(Request $request)
    {
        
        $surat = SuratKeluar::create([
            'nama_surat' => $request->nama_surat,
            'kategori_surat' => 'Surat Undangan',
            'tanggal_dibuat' => $request->tanggal_dibuat,
            'tujuan_surat' => $request->tujuan_surat,
            'kode_surat' => $request->kode_surat,
            'pembuat_surat' => auth()->user()->nama_karyawan,
            'jenis_surat' => 'Template',
            'file' => $request->nama_surat . '.pdf',
            'status' => "Kepala Bagian",
        ]);

        $templateSK = TemplateSK::create([
            'id_surat' => $surat->id,
            'perihal' => $request->perihal,
            'hari_tanggal' => $request->hari_tanggal,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
            'tanggal_surat' => $surat->tanggal_dibuat,
            'pembuat_surat' => $surat->pembuat_surat,
        ]);

        Disposisi::create([
            'id_surat'=> $surat->id,
            'nama_surat' => $surat->nama_surat,
            'status' => $surat->status,
            'deskripsi' => "Surat Telah diajukan oleh HRD",
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);


        // $templateSK = TemplateSK::find($id);
        $pdf = PDF::loadView('admin.TemplateSK.template', compact('templateSK'));
        $file_name = $surat->nama_surat . '.pdf';
        $file_path = public_path('assets/suratkeluar/') . $file_name;
        $pdf->save($file_path);
        // Redirect ke halaman templateSK.show dengan menambahkan ID baru
        return redirect()->route('suratkeluar.index')
            ->with('success', 'Data berhasil disimpan!');
    }

    public function showDesk()
    {
        // $templateSK = TemplateSK::find($id);
        return view('admin.TemplateSK.show');
    }
    public function storeSKnew(Request $request)
    {
        $SuratKeluar = SuratKeluar::create([
            'nama_surat' => $request->nama_surat,
            'kategori_surat' => $request->kategori_surat,
            'tanggal_dibuat' => $request->tanggal_dibuat,
            'tujuan_surat' => $request->tujuan_surat,
            'kode_surat' => $request->kode_surat,
            'pembuat_surat' => 1,
            'jenis_surat' => $request->jenis_surat,
            'file' => $request->nama_surat . '.pdf',
            'status' => "menunggu disetujui",
        ]);

        $id = $SuratKeluar->id;

        return view('admin.TemplateSK.create', compact('id'));
    }
    // public function show($id)
    // {
    //     $templateSK = TemplateSK::find($id);
    //     return view('admin.TemplateSK.show', compact('templateSK'));
    // }
    // public function storeTemplate(Request $request, $id)
    // {
    //     $templateSK = TemplateSK::find($id);
    //     $pdf = PDF::loadView('admin.TemplateSK.template', compact('templateSK'));
    //     $file_name = $request->nama_surat . '_' . uniqid() . '.pdf';
    //     $file_path = storage_path('../public/assets/surat/') . $file_name;
    //     $pdf->save($file_path);

    //     SuratKeluar::create([
    //         'nama_surat' => $request->nama_surat,
    //         'kategori_surat' => $request->kategori_surat,
    //         'tanggal_dibuat' => $request->tanggal_dibuat,
    //         'tujuan_surat' => $request->tujuan_surat,
    //         'kode_surat' => $request->kode_surat,
    //         'pembuat_surat' => 1,
    //         'jenis_surat' => $request->jenis_surat,
    //         'file' => $file_name,
    //         'status' => "menunggu disetujui",
    //     ]);

    //     // $file1->move(public_path($location1), $filename1);
    //     Session::flash('success', 'Data surat Berhasil Ditambahkan');
    //     return redirect()->route('suratkeluar.index')->with('success', 'surat berhasil ditambahkan.');
    // }

    public function priview(Request $request, $id)
    {
        $templateSK = TemplateSK::where('id_surat', $id)->first();
        // $pdf = PDF::loadView('admin.TemplateSK.signature', compact('templateSK'));
        return view('admin.TemplateSK.priview', compact('templateSK'));
    }
    public function edit(TemplateSK $templateSK)
    {
        //
    }
    public function Sign($id)
    {
        $templateSK = TemplateSK::where('id', $id)->first();
        $templateSK->tanda_tangan=auth()->user()->tanda_tangan;
        $templateSK->save();
     

        $surat = SuratKeluar::where('id', $templateSK->id_surat)->first();
        $surat->status="disetujui";
        $surat->save();

        $pdf = PDF::loadView('admin.TemplateSK.signature', compact('templateSK'));
       
        $file_name = $surat -> file;
        $file_path = public_path('assets/suratkeluar/').$file_name;
        
    
        $FileToDelete = public_path('../public/assets/suratkeluar/') .$surat->file;

        if (File::exists($FileToDelete)){
            File::delete($FileToDelete);
            $pdf->save($file_path);
        }

        else{
            $pdf->save($file_path);
            // return 'Filer not found';
        }

            // Redirect ke halaman templateSK.show dengan menambahkan ID baru
            return redirect()->route('suratkeluar.index')
                ->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTemplateSKRequest $request, TemplateSK $templateSK)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TemplateSK $templateSK)
    {
        //
    }
}
