<?php

namespace App\Http\Controllers\Api;

use App\Models\Bagian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;


class SendDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function terimabagian(Request $request)
    {
        $data = $request->input('data1');
        $presensidata = json_decode($data, true);
        $prettyJson = json_encode($presensidata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        $dataArray = json_decode($prettyJson, true);

        foreach ($dataArray as $data) {
            Bagian::create(['nama_bagian' => $data['DEPTNAME']]);
        }
    

     


        return response()->json(['message' => 'Data received successfully']);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
