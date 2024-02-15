<?php

namespace App\Http\Controllers\Api;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;





class PresensiApiController extends Controller
{
    public function recieve(Request $request){
        $data = $request->input('data');

        dd($data);

        // Lakukan apa pun yang perlu Anda lakukan dengan data
        // ...

        // Mengembalikan respons
        return response()->json(['message' => 'Data received successfully']);
    }
}
