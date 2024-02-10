<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBagianRequest;
use App\Http\Requests\UpdateBagianRequest;

class BagianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bagians = Bagian::all();
        $title="Daftar Bagian";
        return view('admin.bagian.index', compact('bagians','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title="Tambah Bagian Bagian";
        return view('admin.bagian.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_bagian' => 'required|string|max:255|unique:bagian,nama_bagian',
        ], [
            'nama_bagian.unique' => 'Nama bagian sudah digunakan. Harap pilih nama bagian yang lain.',
        ]);


        Bagian::create($request->all());

        return redirect()->route('bagian.index')->with('success', 'Bagian created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bagian  $bagian
     * @return \Illuminate\Http\Response
     */
    public function edit(Bagian $bagian)
    {
        return view('admin.bagian.edit', compact('bagian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bagian  $bagian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bagian $bagian)
    {
        $request->validate([
            'nama_bagian' => 'required|string|max:255|unique:bagian,nama_bagian',
        ], [
            'nama_bagian.unique' => 'Nama bagian sudah digunakan. Harap pilih nama bagian yang lain.',
        ]);

        $bagian->update($request->all());

        return redirect()->route('bagian.index')->with('success', 'Bagian updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bagian  $bagian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bagian $bagian)
    {
        $bagian->delete();

        return redirect()->route('bagian.index')->with('success', 'Bagian deleted successfully.');
    }
}