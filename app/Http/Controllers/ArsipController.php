<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;





class ArsipController extends Controller
{
    public function index()
    {
        $arsips = Arsip::all();
        $title = "Arsip";
        return view("admin.arsip.index", compact(["arsips", "title"]));
    }
    public function create()
    {
        $title = "Tambah Arsip";
        return view("admin.arsip.create", compact(["title"]));
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $file1 = $validatedData['file'];
        $filename1 = $file1->getClientOriginalName();
        $location1 = 'assets/file/';

        Arsip::create([
            'nama_arsip' => $request->nama_arsip,
            'kode_arsip' => $request->kode_arsip,
            'perihal' => $request->perihal,
            'lokasi_arsip' => $request->lokasi_arsip,
            'kategori' => $request->kategori,
            'tanggal_selesai' => $request->tanggal_selesai,
            'file' => $filename1,
        ]);

        $title = "Tambah Arsip";

        $file1->move(public_path($location1), $filename1);
        $arsips = Arsip::all();
        Session::flash('success', 'Data Arsip Berhasil Ditambahkan');
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil ditambahkan.');
    }


    public function show(Arsip $arsip)
    {
        //
    }


    public function edit($id)
    {
        $title = "Edit Arsip";
        $arsip = Arsip::where('id', $id)->first();
        return view('admin.arsip.edit', compact(['title', 'arsip']));
    }

    public function update(Request $request, $id)
    {
        $arsip = Arsip::where('id', $id)->first();
        // dd($arsip);
        $arsip->nama_arsip = $request->input('nama_arsip');
        $arsip->kode_arsip = $request->input('kode_arsip');
        $arsip->perihal = $request->input('perihal');
        $arsip->lokasi_arsip = $request->input('lokasi_arsip');
        $arsip->kategori = $request->input('kategori');
        $arsip->tanggal_selesai = $request->input('tanggal_selesai');

        $arsip->save();

        $title = "Edit Arsip";
        Session::flash('success', 'Data Arsip Berhasil DiUbah');
        $arsips = Arsip::all();
        // return redirect()->route('arsip.index')->with('success', 'User berhasil diupdate.');
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil diupdate.');

    }

    public function destroy($id)
    {
        $data = Arsip::where('id', $id)->first();
        $data->delete();
        Session::flash('success', 'Data Arsip Berhasil Dihapus');

        // $title = "Arsip";
        $arsips = Arsip::all();
        // return view('admin.arsip.index',compact(['arsips','title']));
        return redirect()->back();
    }
    public function downloadarsip(Request $request, $id, $file)
    {

        $arsip = Arsip::find($id);

        if (!$arsip) {
            abort(404);
        }
        $file_path = storage_path('../public/assets/file/') . $arsip->file;
        // dd($file_path);


        // Tentukan nama file yang akan di-download
        $file = $arsip->file;
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
}
