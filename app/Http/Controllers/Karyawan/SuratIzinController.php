<?php

namespace App\Http\Controllers\Karyawan;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\User;
use App\Models\Shift;
use App\Models\Jadwal;
use Twilio\Rest\Client;
use App\Models\Presensi;
use App\Models\Disposisi;
use App\Models\SuratIzin;
use App\Models\TemplateSK;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;





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
     
        $explodedDate = explode("-", $request->tanggal_izin);
        $month = $explodedDate[1];
        $year= $explodedDate[0];
        $time= $year."-".$month;

       
        $jumlahIzin= SuratIzin::where('nama_pengaju',auth()->user()->nama_karyawan)->where('tanggal_izin',"LIKE","$time%")->count();
        

        if ($jumlahIzin >= 3) {
            // Simpan pesan flash jika batas izin terlampaui
            Session::flash('permission_limit_exceeded', 'Batas izin terlampaui. Tidak dapat membuat izin lebih lanjut.');
        }
        else{
            $kepala = User::where(function ($query) {
                $query->where('jabatan', 'Kepala Bagian')
                      ->orWhere('jabatan', 'Kepala Ruangan');
            })
            ->where('nama_bagian', auth()->user()->nama_bagian)
            ->first();
    
            if($kepala!=null){
                $status=$kepala->jabatan;
    
            }
            else{
                $status='Direktur';
            }
    
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
                'bagian' => auth()->user()->nama_bagian,
                'keterangan' => $request->keterangan,
                'bukti' => $filename2,
                'status' => $status,
                // 'tanda_tangan' => 'ttd.jpg',
                // 'file' => $filename1,
            ]);
    
            $suratIzin->nama_surat ="Surat Izin ".auth()->user()->nama_karyawan.$suratIzin->id;
            $suratIzin->save();
            $pdf = PDF::loadView('karyawan.SuratIzin.templateizin', compact('suratIzin'));
            $file_name = $suratIzin->nama_surat  . '.pdf';
            $file_path = public_path('assets/suratIzin/') . $file_name;
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

        }


        
        return redirect()->back();
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
        $suratIzin->tanda_tangan_direktur = auth()->user()->tanda_tangan;
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

        $pengaju=User::where('nama_karyawan',$suratIzin->nama_pengaju)->first();
        $carbonDate = Carbon::createFromFormat('Y-m-d', $suratIzin->tanggal_izin);
        $convertedDateFormat1 = $carbonDate->format('d/m/Y');
      
        Presensi::updateOrCreate([
            'id_karyawan' => $pengaju->id,
            'nama_karyawan' => $pengaju->nama_karyawan,
            'nama_bagian' => $pengaju->nama_bagian,
            'cin1' => null,
            'cout1' => null,
            'cin2' => null,
            'cout2' => null,
            'status' => 'izin',
            'tanggal' => $convertedDateFormat1
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
