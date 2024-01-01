<?php

namespace App\Http\Controllers;

use App\Models\Arsip;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts=Shift::all();
        $title="Daftar Shift";
        return view('admin.shift.index',compact('shifts','title'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title="Tambah Shift Baru";
        return view('admin.shift.create',compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_shift' => 'required|string',
            'bagian' => 'required|string',
            'kode_shift' => 'required|string',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
        ]);



        // Adjust the file handling logic based on your requirements
        // ...

        Shift::create([
            'nama_shift' => $request->nama_shift,
            'kode_shift' => $request->kode_shift,
            'bagian' => $request->bagian,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);

        return redirect()->route('shift.index')->with('success', 'Arsip created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Edit Shift";
        $shift = Shift::where('id', $id)->first();
        return view('admin.shift.edit', compact(['title', 'shift']));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
      
        $request->validate([
            'nama_shift' => 'required',
            'kode_shift' => 'required',
            'bagian' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required'
        ]);
        


        $shift = Shift::findOrFail($id);
     
        $shift->update($request->all());

        return redirect()->route('shift.index')->with('success', 'Data shift berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Shift::where('id', $id)->first();
        $data->delete();
        Session::flash('success', 'Data Shift Berhasil Dihapus');

        // $title = "Arsip";
        $arsips = Shift::all();
        // return view('admin.arsip.index',compact(['arsips','title']));
        return redirect()->back();
    }
}
