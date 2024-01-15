<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\DataPresensi;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresensiRequest;
use App\Http\Requests\UpdatePresensiRequest;

class PresensiController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $conn = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=/path/to/your/database.mdb", "", "");

        if ($conn) {
            // Query your Access database
            $result = odbc_exec($conn, "SELECT * FROM your_table");

            while ($row = odbc_fetch_array($result)) {
                print_r($row);
            }

            // Close the connection
            odbc_close($conn);
        } else {
            echo "Failed to connect to the Access database.";
        }
        // Ambil semua data jadwal
        $jadwals = Jadwal::all();

   

        // Loop melalui setiap jadwal
        foreach ($jadwals as $jadwal) {
       
            // Ambil data presensi yang sesuai dengan jadwal
            $dataPresensi = DataPresensi::where([
            
            ])->get();
            for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, 1, now()->format('Y')); $day++) {
                $data = Jadwal::where("tanggal_$day", '!=', null)->pluck("tanggal_$day")->toArray();
            
                // Jika data ditemukan, ambil nilai pertama dari array
                $dayValue = !empty($data) ? $data[0] : null;
            
                // Menyimpan nilai ke dalam array $dayValues
                $dayValues["tanggal_$day"] = $dayValue;
               

                $tanggal="$day"."/12/2023";
                $presensi = DataPresensi::where('badgenumber', $jadwal->user_id)
                    ->where('eDate', $tanggal)
                    ->first();
             

                $shiftDay=Shift::where('id',$dayValue)->first();


              

    

             // String berisi 4 data terpisah dengan spasi
                $stringData = '12:30:00 12:30:00 16:00:00 17:15:00';

                // Pecah string menjadi array
                $arrayData = explode(' ', $presensi->stime);
                // Hapus elemen yang duplikat dari array
                $uniqueArray = array_unique($arrayData);
                // Gabungkan kembali array menjadi string
                $arrayData = implode(' ', $uniqueArray);

                $arrayData = explode(' ', $arrayData);
         

                
            
                
                if ($shiftDay->cin2 != null) {
                    $columns = ['cin1', 'cout1', 'cin2', 'cout2'];
                } else {
                    $columns = ['cin1', 'cout1'];
                }
                
                // Konversi nilai dalam kolom waktu menjadi objek DateTime
                foreach ($columns as $col) {
                    $shiftDay->$col = new \DateTime($shiftDay->$col);
                }
                
                $cin1 = $cout1 = $cin2 = $cout2 = null;
                $closestIndex = null; // Inisialisasi $closestIndex di luar loop
                
                // Iterasi melalui kolom-kolom waktu
                foreach ($columns as $col) {
                    // Hitung selisih waktu dan ambil indeks dengan selisih waktu terkecil
                    $closestIndex = array_search(
                        min(array_map(
                            function ($time) use ($shiftDay, $col) {
                                // Konversi nilai string menjadi objek DateTime
                                $time = new \DateTime($time);
                                return abs(($shiftDay->$col)->getTimestamp() - $time->getTimestamp());
                            },
                            $arrayData
                        )),
                        array_map(
                            function ($time) use ($shiftDay, $col) {
                                // Konversi nilai string menjadi objek DateTime
                                $time = new \DateTime($time);
                                return abs(($shiftDay->$col)->getTimestamp() - $time->getTimestamp());
                            },
                            $arrayData
                        )
                    );
                
                    // Pastikan bahwa variabel adalah objek DateTime sebelum menggunakan getTimestamp()
                  
                        ${$col} = $arrayData[$closestIndex];  
                       
                        
                 }
                 if($shiftDay->cin2==null){
                    if($cin1!=null){
                        
              
                        $cin1 = new \DateTime($cin1);

                        dd($shiftDay->cin1->getTimestamp()-$cin1->getTimestamp());
                        
                        if(($shiftDay->cin1->getTimestamp()-$cin1->getTimestamp())>300){
                            $selisihWaktu = $shiftDay->cin1->diff($cin1);
                            // Menghitung selisih waktu dalam menit
                            $selisihJam = ($selisihWaktu->h) + (round($selisihWaktu->i/30)*0.5);
                        }

                  
               
                        
                     
                
                        // Pembulatan ke kelipatan 30 menit dengan pembulatan ke atas
                 

                    }
                 }
                 
                 

                
            }
        
    



            if ($dataPresensi) {
                // Ambil shift dari jadwal
                $shift = Shift::find($jadwal->shift_id);

                // Bandingkan data shift dengan data presensi
                if ($shift->kode_shift == $dataPresensi->kode_shift) {
                    // Sesuaikan logika atau tindakan yang perlu diambil
                    // Misalnya, Anda dapat memasukkan data presensi ke dalam tabel tertentu
                    // atau melakukan tindakan lain sesuai kebutuhan aplikasi Anda.
                    // Contoh:
                    // Presensi::create([
                    //     'user_id' => $jadwal->user_id,
                    //     'tanggal' => $jadwal->tanggal,
                    //     'shift_id' => $jadwal->shift_id,
                    //     'status' => 'Hadir', // Sesuaikan dengan logika presensi Anda
                    // ]);
                }
            }
        }

        // Tambahkan respons atau tindakan lain yang diperlukan
        return response()->json(['message' => 'Data presensi berhasil dimasukkan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresensiRequest $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        //
    }
}
