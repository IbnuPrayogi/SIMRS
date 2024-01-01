<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;

class ShiftController extends Controller
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
        $title="Tambah Shift Baru";
        return view('admin.shift.create',\compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_shift' => 'required|string',
            'bagian' => 'required|string',
            'jam_masuk' => 'required|date',
            'jam_pulang' => 'required|date',
        ]);

        // Adjust the file handling logic based on your requirements
        // ...

        Arsip::create([
            'nama_shift' => $request->nama_shift,
            'bagian' => $request->bagian,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);

        return redirect()->route('shift.create')->with('success', 'Arsip created successfully');
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
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShiftRequest $request, Shift $shift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        //
    }
}
