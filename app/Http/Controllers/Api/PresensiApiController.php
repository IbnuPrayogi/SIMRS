<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Arsip;
use App\Models\Check;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;





class PresensiApiController extends Controller
{
    public function terima(Request $request){
 
        $datas = $request->input('data1');
        $presensidata = json_decode($datas, true);
        $prettyJson = json_encode($presensidata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

       
        foreach ($presensidata as $data) {
            // Cek apakah baris identik sudah ada dalam tabel
            $existingData = Check::where('userid', $data['USERID'])
                ->where('nama_karyawan', $data['UserName'])
                ->where('waktu', $data['CHECKTIME'])
                ->first();

            // Jika tidak ada, simpan data
            if (!$existingData) {
                $checkData = new Check();
                $checkData->userid = $data['USERID'];
                $checkData->nama_karyawan = $data['UserName'];
                $checkData->waktu = $data['CHECKTIME'];
                $checkData->save();
            }
        }

        return redirect()->back()->with('success',"Data Berhasil Di Import");


    }
    public function getAllUsers()
    {
      
        $users = User::all();

        return Response::json(['data' => $users], 200);
    }
}

