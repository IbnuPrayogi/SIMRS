<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PostDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function storebagian()
    {
    
        $conn = odbc_connect('MS Access Database', '111', '111');
    
        if ($conn) {
         


            $sql1 = "SELECT DEPTNAME FROM DEPARTMENTS";
            

            $result1 = odbc_exec($conn, $sql1);
            
    
            if ($result1) {
                $data = [];
                $data2 =[];
    
                while ($row1 = odbc_fetch_array($result1)) {
                    // Clean each element of the array to ensure it's valid UTF-8
                    $cleanedRow = array_map(function ($item) {
                        return mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                    }, $row1);
    
                    $data[] = $cleanedRow;
                    
                }
    

            
                odbc_close($conn);
    
                // Encode the array of data with JSON_UNESCAPED_UNICODE
                $json = json_encode($data, JSON_UNESCAPED_UNICODE);
              
             
                
    
                // Menggunakan Axios untuk mengirim data ke endpoint
                $axiosResponse = Http::withOptions(['timeout' => 60])->asJson()->post('http://127.0.0.1:8001/api/kirimdata/bagian', ['data1' => $json]);
              

    
                // Mengembalikan respons dari controller lain
                return $axiosResponse;
            } else {
                odbc_close($conn);
                return response()->json(['error' => 'Error executing query'], 500);
            }
        } else {
            return response()->json(['error' => 'Failed to connect to MS Access Database'], 500);
        }
    }

    public function storeuser()
    {
        $conn = odbc_connect('MS Access Database', '111', '111');
    
        if ($conn) {
         


            $sql1 = "SELECT   FROM USERINFO";
            

            $result1 = odbc_exec($conn, $sql1);
            
    
            if ($result1) {
                $data = [];
                $data2 =[];
    
                while ($row1 = odbc_fetch_array($result1)) {
                    // Clean each element of the array to ensure it's valid UTF-8
                    $cleanedRow = array_map(function ($item) {
                        return mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                    }, $row1);
    
                    $data[] = $cleanedRow;
                    
                }
    

            
                odbc_close($conn);
    
                // Encode the array of data with JSON_UNESCAPED_UNICODE
                $json = json_encode($data, JSON_UNESCAPED_UNICODE);
              
             
                
    
                // Menggunakan Axios untuk mengirim data ke endpoint
                $axiosResponse = Http::withOptions(['timeout' => 60])->asJson()->post('http://127.0.0.1:8001/api/kirimdata/user', ['data1' => $json]);
              

    
                // Mengembalikan respons dari controller lain
                return $axiosResponse;
            } else {
                odbc_close($conn);
                return response()->json(['error' => 'Error executing query'], 500);
            }
        } else {
            return response()->json(['error' => 'Failed to connect to MS Access Database'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
