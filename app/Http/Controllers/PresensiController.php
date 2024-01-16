<?php

namespace App\Http\Controllers;

use App\Models\Potongan;
use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\DataPresensi;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresensiRequest;
use App\Http\Requests\UpdatePresensiRequest;
use App\Models\Terlambat;

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

           

                if($presensi!=null){
                    $status='tepat waktu';
                    $shiftDay=Shift::where('id',$dayValue)->first();
                    // String berisi 4 data terpisah dengan spasi
                       $arrayData = explode(' ', $presensi->stime);
                       // Hapus elemen yang duplikat dari array
                       $uniqueArray = array_unique($arrayData);
                       // Gabungkan kembali array menjadi string
                       $arrayData = implode(' ', $uniqueArray);
       
                       $arrayData = explode(' ', $arrayData);

                     

                       // Convert the array of time to seconds
                       $arraySeconds = array_map(function ($time) {
                           list($hours, $minutes) = explode(':', $time);
                           return ($hours * 3600) + ($minutes * 60);
                       }, $arrayData);
               
                       // Sort the array of seconds
                       sort($arraySeconds);
               
                       // Filter the array of seconds with a 10-minute range
                       $selectedSeconds = [$arraySeconds[0]];
               
                       foreach ($arraySeconds as $seconds) {
                           $difference = abs(end($selectedSeconds) - $seconds);
               
                           // If the difference is more than 10 minutes (600 seconds), add it to the result array
                           if ($difference >= 600) {
                               $selectedSeconds[] = $seconds;
                           }
                       }
               
                       // Convert the selected seconds back to HH:MM format
                       $selectedTime = array_map(function ($seconds) {
                           return gmdate('H:i', $seconds);
                       }, $selectedSeconds);
               
                       // Join the array back into a string
                       $arrayData = implode(' ', $selectedTime);
                       $arrayData= explode(' ',$arrayData);
                     
                       
                
       
                       if ($shiftDay->cin2!=null) {
                           $columns = ['cin1', 'cout1', 'cin2', 'cout2'];
                       } 
                       else{
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
                           if(count($arrayData)!=0){
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
                                unset($arrayData[$closestIndex]);
                           }

                      
                           // Hitung selisih waktu dan ambil indeks dengan selisih waktu terkecil
                            
                               
                              
                               
                        }
                        

                  
                       if($shiftDay->cin1 !=null && $shiftDay->cout1!= null){
                           if($cin1!=null && $cout1!=null && $cin1!= $cout1){

                              
                            
                               $cin1 = new \DateTime($cin1);
                               if(($cin1->getTimestamp()-$shiftDay->cin1->getTimestamp())>300){
                                   $selisihWaktu = $shiftDay->cin1->diff($cin1);
                                   // Menghitung selisih waktu dalam menit
                                   $waktuTelat = ($selisihWaktu->h) + (round($selisihWaktu->i/30)*0.5);

                                   Terlambat::create([
                                    'user_id'=>$presensi->badgenumber,
                                    'shift_id'=>$shiftDay->id,
                                    'tanggal'=>$presensi->eDate,
                                    'waktu_terlambat'=>$waktuTelat
                                   ]);
                                   $status='terlambat';
                               }

                               $cout1 = new \DateTime($cout1);
                             
                               if(($shiftDay->cout1->getTimestamp()-$cout1->getTimestamp())>300){
                           
                                   $timeDifferent = $shiftDay->cout1->getTimestamp()-$cout1->getTimestamp();
                                   
                                   // Menghitung selisih waktu dalam menit
                                   $waktuPulangCepat = round($timeDifferent/1800)*0.5;

                                   Potongan::create([
                                    'user_id'=>$presensi->badgenumber,
                                    'shift_id'=>$shiftDay->id,
                                    'tanggal'=>$presensi->eDate,
                                    'waktu_potongan'=>$waktuPulangCepat
                                   ]);

                                   if($status!='terlambat'){
                                    $status='potongan';
                                   }
                                   else{
                                    $status='terlambat dan terpotong';
                                   }
                               }

                            
                  
                           }
                           else{
                            $status='alfa';
                            
                            }
                       
                       }
                     
                       Presensi::create([
                        'id_karyawan'=>$jadwal->user_id,
                        'nama_karyawan'=>$presensi->username,
                        'nama_bagian'=>$presensi->deptname,
                        'cin1'=>$cin1,
                        'cout1'=>$cout1,
                        'cin2'=>$cin2,
                        'cout2'=>$cout2,
                        'status'=>$status,
                        'tanggal'=>$presensi->eDate
                       ]);

                    //    Terlambat::updateOrCreate(
                    //     [
                    //         'user_id' => $request->input('user_id'),
                    //         'tanggal' => $request->input('tanggal'),
                    //     ],
                    //     [
                    //         'jumlah_terlambat' => $request->input('jumlah_terlambat'),
                    //     ]
                    //      );

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
