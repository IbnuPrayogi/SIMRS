<?php

namespace App\Http\Controllers;

use App\Models\ListRequestLetter;
use App\Http\Requests\StoreListRequestLetterRequest;
use App\Http\Requests\UpdateListRequestLetterRequest;
use App\Models\SuratCuti;
use App\Models\SuratIzin;
use App\Models\SuratTukarJaga;

class ListRequestLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexIzin()
    {
        $Izins = SuratIzin::where('bagian',auth()->user()->nama_bagian)->get();
        return view("admin.DaftarPermohonanIzin.index" , compact('Izins'));
    }
    public function indexCuti()
    {
        $Cutis = SuratCuti::where('bagian',auth()->user()->nama_bagian)->get();
        return view("admin.DaftarPermohonanCuti.indexCuti" , compact('Cutis'));
    }
    public function indexTukarJaga()
    {
        $TukarJagas = SuratTukarJaga::where('bagian',auth()->user()->nama_bagian)->get();
        return view("admin.DaftarPermohonanTukarJaga.indexTukarJaga" , compact('TukarJagas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListRequestLetterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ListRequestLetter $listRequestLetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListRequestLetter $listRequestLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListRequestLetterRequest $request, ListRequestLetter $listRequestLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListRequestLetter $listRequestLetter)
    {
        //
    }
}
