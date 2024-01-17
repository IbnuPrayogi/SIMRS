<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

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
            'cin1' => 'required|date_format:H:i',
            'cout1' => 'required|date_format:H:i',
        ]);
        
        // Adjust the file handling logic based on your requirements
        // ...
        
        $jamMasuk1 = Carbon::createFromFormat('H:i', $request->cin1);
        $jamPulang1 = Carbon::createFromFormat('H:i', $request->cout1);
        $lamaWaktu = $jamPulang1->diff($jamMasuk1);
        if($request->cin2!=null){
            $jamMasuk2 = Carbon::createFromFormat('H:i', $request->cin2);
            $jamPulang2 = Carbon::createFromFormat('H:i', $request->cout2);
            $lamaWaktu2 = $jamPulang2->diff($jamMasuk2);

            $lamaWaktu=$lamaWaktu->add($lamaWaktu2);

        }
        else{
            $jamMasuk2=$jamPulang2=null;
        }
        
        // Check if both $jamMasuk and $jamPulang are valid Carbon instances
        if ($jamMasuk1 instanceof Carbon && $jamPulang1 instanceof Carbon) {
            // Calculate the time difference in hours and minutes
            

        
            Shift::create([
                'nama_shift' => $request->nama_shift,
                'kode_shift' => $request->kode_shift,
                'bagian' => $request->bagian,
                'cin1' => $jamMasuk1->format('H:i'), // Format as string
                'cout1' => $jamPulang1->format('H:i'),
                'cin2' => $jamMasuk1->format('H:i'), // Format as string
                'cout2' => $jamPulang1->format('H:i'), // Format as string
                'lama_waktu' => $lamaWaktu->format('%H:%I'), // Format time difference as string
            ]);
        
            return redirect()->route('shift.index')->with('success', 'Arsip created successfully');
        } else {
            // Handle the case where $jamMasuk or $jamPulang is not a valid time
            return redirect()->back()->with('error', 'Invalid time format');
        }
        

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
