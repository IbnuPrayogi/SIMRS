<?php

namespace App\Http\Controllers;

use App\Models\SuratIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use App\Models\Disposisi;





class SuratIzinController extends Controller
{
    public function index()
    {
        return view("karyawan.SuratIzin.index");
    }
    public function create()
    {
        return view("karyawan.SuratIzin.create");
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'file' => 'mimes:pdf,doc,docx|max:5120',
            'bukti' => 'mimes:pdf,doc,docx|max:5120',
        ]);

        // dd(SuratIzin::all());]
        // $file1 = $validatedData['file'];
        $file2 = $validatedData['bukti'];
        // $filename1 = $file1->getClientOriginalName();
        $filename2 = $file2->getClientOriginalName();
        $location1 = 'assets/surat/';
        $location2 = 'assets/bukti/';

        $suratIzin = SuratIzin::create([
            'nama_pengaju' => auth()->user()->nama_karyawan,
            'tanggal_izin' => $request->tanggal_izin,
            'bagian' => $request->bagian,
            'keterangan' => $request->keterangan,
            'bukti' => $filename2,
            'status' => "Manajer",
            'tanda_tangan'=>auth()->user()->tanda_tangan
            // 'tanda_tangan' => 'ttd.jpg',
            // 'file' => $filename1,
        ]);

        $suratIzin->nama_surat ="Surat Izin ".auth()->user()->nama_karyawan.$suratIzin->id;
        $suratIzin->save();
        $pdf = PDF::loadView('karyawan.SuratIzin.templateizin', compact('suratIzin'));
        $file_name = $suratIzin->nama_surat  . '.pdf';
        $file_path = storage_path('../public/assets/suratIzin/') . $file_name;
        $pdf->save($file_path);
        $suratIzin->file = $file_name;
        $suratIzin->save();

        Disposisi::create([
            'id_surat'=> $suratIzin->id,
            'nama_surat' => $suratIzin->nama_surat,
            'status' => $suratIzin->status,
            'deskripsi' => "Surat Telah diajukan oleh ".$suratIzin->nama_pengaju,
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);


        // $file1->move(public_path($location1), $filename1);
        Session::flash('success', 'Data surat Berhasil Ditambahkan');
        return redirect()->route('suratizin.create')->with('success', 'surat berhasil ditambahkan.');
    }

    public function storeSKForm(Request $request, $id)
    {
        $surat = SuratIzin::find($id);

        // $suratIzin = TemplateSK::create([
        //     'id_surat' => $surat->id,
        //     'perihal' => $request->perihal,
        //     'hari_tanggal' => $request->hari_tanggal,
        //     'waktu' => $request->waktu,
        //     'tempat' => $request->tempat,
        //     'tanggal_surat' => $request->tanggal_surat,
        //     'pembuat_surat' => 1,
        // ]);

        // // $templateSK = TemplateSK::find($id);
        // $pdf = PDF::loadView('admin.TemplateSK.template', compact('templateSK'));
        // $file_name = $surat->nama_surat . '.pdf';
        // $file_path = storage_path('../public/assets/surat/') . $file_name;
        // $pdf->save($file_path);
        // // Redirect ke halaman templateSK.show dengan menambahkan ID baru
        // return redirect()->route('suratkeluar.index')
        //     ->with('success', 'Data berhasil disimpan!');


        // if ($request->tanggal_mulai && $request->tanggal_selesai) {
        //     // Konversi tanggal_mulai dan tanggal_selesai ke objek Carbon
        //     $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        //     $tanggalSelesai = Carbon::parse($request->tanggal_selesai);

        //     // Hitung durasi antara dua tanggal
        //     $durasi = $tanggalMulai->diffInDays($tanggalSelesai);

        //     // Atur nilai durasi dan simpan objek SuratIzin
        //     $suratIzin->durasi = $durasi;
        //     $suratIzin->save();
        // }

    }

    public function showDesk()
    {
        // $templateSK = TemplateSK::find($id);
        return view('admin.TemplateSK.show');
    }
    public function storeSKnew(Request $request)
    {
        // $SuratKeluar = SuratKeluar::create([
        //     'nama_surat' => $request->nama_surat,
        //     'kategori_surat' => $request->kategori_surat,
        //     'tanggal_dibuat' => $request->tanggal_dibuat,
        //     'tujuan_surat' => $request->tujuan_surat,
        //     'kode_surat' => $request->kode_surat,
        //     'pembuat_surat' => 1,
        //     'jenis_surat' => $request->jenis_surat,
        //     'file' => $request->nama_surat . '.pdf',
        //     'status' => "menunggu disetujui",
        // ]);

        // $id = $SuratKeluar->id;

        // return view('admin.TemplateSK.create', compact('id'));
    }
    public function priview(Request $request, $id)
    {
        $suratIzin = SuratIzin::where('id', $id)->first();
        // $pdf = PDF::loadView('admin.TemplateSK.signature', compact('templateSK'));
        return view('admin.DaftarPermohonanIzin.priview', compact('suratIzin'));
    }
    public function Sign($id)
    {

        $suratIzin = suratIzin::where('id', $id)->first();
        $suratIzin->manajer = auth()->user()->tanda_tangan;
        $suratIzin->nama_manajer = auth()->user()->nama_karyawan;
        $suratIzin->save();

        $pdf = PDF::loadView('admin.DaftarPermohonanIzin.signature', compact('suratIzin'));
        $file_name = 'ACC_' . $suratIzin->file; // Assuming you want to prepend 'ACC_' to the existing file name
        $file_path = public_path('../public/assets/suratIzin/') . $file_name;

        $FileToDelete = public_path('../public/assets/suratIzin/') . $suratIzin->file;

        if (File::exists($FileToDelete)) {
            File::delete($FileToDelete);
            $pdf->save($file_path);
        } else {
            $pdf->save($file_path);
        }

        // Update the file attribute in the database
        $suratIzin->file = $file_name;
        $suratIzin->status = "disetujui";
        $suratIzin->save();

        Disposisi::create([
            'id_surat'=> $suratIzin->id,
            'nama_surat' => $suratIzin->nama_surat,
            'status' => 'disetujui',
            'deskripsi' => "Surat Telah disetujui ",
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        // Redirect ke halaman suratIzin.show dengan menambahkan ID baru
        return redirect()->route('DaftarPermohonan.indexIzin')
            ->with('success', 'Data berhasil disimpan!');
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

    public function Tolak($id){
        $suratIzin = SuratIzin::where('id', $id)->first();

        $suratIzin->status= 'ditolak';

        $suratIzin->save();

        Disposisi::create([
            'id_surat'=> $suratIzin->id,
            'nama_surat' => $suratIzin->nama_surat,
            'status' => $suratIzin->status,
            'deskripsi' => "Surat Telah Ditolak oleh Kepala Bagian",
            // Tambahkan kolom-kolom lainnya sesuai kebutuhan
        ]);

        return redirect()->route('DaftarPermohonan.indexIzin')
            ->with('success', 'Permohonan Izin Ditolak!');
    }
}
