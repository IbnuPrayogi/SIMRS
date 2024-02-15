<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\User;
use App\Models\Shift;
use App\Models\Bagian;
use App\Models\Jadwal;
use App\Models\Potongan;
use App\Models\Presensi;
use App\Models\Terlambat;
use App\Models\DataPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StorePresensiRequest;
use App\Http\Requests\UpdatePresensiRequest;
use Illuminate\Support\Facades\Http;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->query('selectedMonth', now()->format('m'));
        $selectedYear = $request->query('selectedYear', now()->format('Y'));
        $selectedDepartment = $request->query('selectedDepartment', 'Satpam');

        $users = User::where('nama_bagian',$selectedDepartment)->where('role',3)->get();
        $shifts = Shift::where('bagian',$selectedDepartment)->get();
        $jadwal = Jadwal::where('bulan', $selectedMonth)->where('tahun',$selectedYear)->where('nama_bagian',$selectedDepartment)->get();
        $presensi = Presensi::where('nama_bagian',$selectedDepartment)->get();
        $bagians=Bagian::all();

        return View::make('admin.presensi.index', compact('users', 'shifts','jadwal','presensi','bagians'), [
            'bagians' => $bagians,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'selectedDepartment' => $selectedDepartment,
        ]);
        //
    }

    public function indexkaryawan(Request $request)
    {
  
        $selectedMonth = $request->query('selectedMonth', now()->format('m'));
        $selectedYear = $request->query('selectedYear', now()->format('Y'));
        $date=$selectedMonth."/".$selectedYear;
        $shift = Shift::where('bagian',auth()->user()->nama_bagian)->get();
        $jadwal = Jadwal::where('bulan', $selectedMonth)->where('tahun',$selectedYear)->where('nama_karyawan',auth()->user()->nama_karyawan)->first();
        $presensi = Presensi::where('nama_karyawan',auth()->user()->nama_karyawan)->where('tanggal','like','%'.$date)->get();
        if ($presensi->isEmpty()) {
            // Data kosong, Anda dapat menangani ini di sini
            $presensi= null;
        }

        
    
        $bagians=Bagian::all();

        return View::make('karyawan.presensi', compact('jadwal','presensi','bagians','shift'), [
            'bagians' => $bagians,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        
        
        $bulan = intval($request->input('bulan'));
        
     
        $tahun = intval($request->input('tahun'));

        if(intval(now()->format('m'))==$bulan && intval(now()->format('Y'))==$tahun){
            $limit= intval(now()->format('d'));
        }
        else{
            $limit=cal_days_in_month(CAL_GREGORIAN, 1, now()->format('Y'));
        }
 
        $jadwals = Jadwal::where('bulan', 1)->where('tahun',2024)->get();
      
        foreach ($jadwals as $jadwal) {
            $conn = \odbc_connect('MS Access Database','111','111');
            if ($conn) {
                // Query SQL untuk mendapatkan USERID dari USERINFO berdasarkan nama karyawan
                $sql1 = "SELECT USERID FROM USERINFO WHERE Name='$jadwal->nama_karyawan'";
            
                // Menjalankan query
                $result1 = \odbc_exec($conn, $sql1);
            
                // Memeriksa apakah query berhasil dieksekusi
                if ($result1) {
                    // Mengambil data dari hasil query
                    $row1 = \odbc_fetch_array($result1);
            
                    // Memeriksa apakah data ditemukan
                    
                } else {
                    // Menangani kesalahan eksekusi query
                    echo "Terjadi kesalahan dalam menjalankan query.";
                }
            

            for ($day = 1; $day <= $limit; $day++) {
                $data = Jadwal::where("tanggal_$day", '!=', null)->where('bulan', $bulan)->pluck("tanggal_$day")->toArray();
                $tanggal = "$day/$bulan/$tahun";
                $user = User::find($jadwal->user_id);

                $shiftDay = Shift::where('id',$jadwal->{"tanggal_$day"})->first();
                if ($row1) {
                    $userid = $row1['USERID'];
                    $sql2 = "SELECT USERID, CHECKTIME, CHECKTYPE FROM CHECKINOUT WHERE USERID = $userid AND DateValue(CHECKTIME) = #$tanggal#";
                    $result2 = \odbc_exec($conn, $sql2);
                    $combinedTimes = '';
                    while ($row2 = \odbc_fetch_array($result2)) {
                        // Ekstrak waktu dari CHECKTIME
                        $checkTime = date("H:i", strtotime($row2['CHECKTIME']));
                        $combinedTimes .= $checkTime . ' ';
                    }
                    $presensi = rtrim($combinedTimes);
        
                    // Membuat tabel HTML atau melakukan operasi lainnya
                    
                } else {
                    echo "Data tidak ditemukan untuk $jadwal->nama_karyawan";
                }
            

                $datapresensi=Presensi::where('tanggal',$tanggal)->where('nama_karyawan',$user->nama_karyawan)->first();

                if($datapresensi!=null && $datapresensi->status=='izin'){
                    $waktu_izin = Carbon::parse($shiftDay->lama_waktu);

                    Izin::Create([
                        'nama_karyawan' => $jadwal->nama_karyawan,
                        'shift_id' => $shiftDay->id,
                        'tanggal' => $tanggal,
                        'waktu_izin' => $waktu_izin->hour,
                    ]);

                }
                if ($presensi != null && $shiftDay->kode_shift != "L") {
                    $status = 'tepat waktu';

                    $arrayData = explode(' ', $presensi);
                    $uniqueArray = array_unique($arrayData);
                    $arrayData = implode(' ', $uniqueArray);
                    $arrayData = explode(' ', $arrayData);

                    $arraySeconds = array_map(function ($time) {
                        list($hours, $minutes) = explode(':', $time);
                        return ($hours * 3600) + ($minutes * 60);
                    }, $arrayData);

                    sort($arraySeconds);
                    $selectedSeconds = [$arraySeconds[0]];

                    foreach ($arraySeconds as $seconds) {
                        $difference = abs(end($selectedSeconds) - $seconds);

                        if ($difference >= 600) {
                            $selectedSeconds[] = $seconds;
                        }
                    }

                    $selectedTime = array_map(function ($seconds) {
                        return gmdate('H:i', $seconds);
                    }, $selectedSeconds);

                    $arrayData = implode(' ', $selectedTime);
                    $arrayData = explode(' ', $arrayData);

                    $columns = $shiftDay->cin2 != null && $shiftDay->cout2 != null ? ['cin1', 'cout1', 'cin2', 'cout2'] : ['cin1', 'cout1'];

                    foreach ($columns as $col) {
                        $shiftDay->$col = new \DateTime($shiftDay->$col);
                    }

                    $cin1 = $cout1 = $cin2 = $cout2 = null;
                    $closestIndex = null;
                   

                    foreach ($columns as $col) {
                        if (count($arrayData) != 0) {
                            $closestIndex = array_search(
                                min(array_map(
                                    function ($time) use ($shiftDay, $col) {
                                        $time = new \DateTime($time);
                                        return abs(($shiftDay->$col)->getTimestamp() - $time->getTimestamp());
                                    },
                                    $arrayData
                                )),
                                array_map(
                                    function ($time) use ($shiftDay, $col) {
                                        $time = new \DateTime($time);
                                        return abs(($shiftDay->$col)->getTimestamp() - $time->getTimestamp());
                                    },
                                    $arrayData
                                )
                            );

                            ${$col} = $arrayData[$closestIndex];
                            unset($arrayData[$closestIndex]);
                        }
                    }
                        if ($shiftDay->cin1 != null && $shiftDay->cout1 != null) {
                            if ($cin1 != null) {

                                if (!($cin1 instanceof \DateTime)) {
                                    $cin1= new \DateTime($cin1);
                                }
                               
                           

                                if (($cin1->getTimestamp() - $shiftDay->cin1->getTimestamp()) > 300) {
                                    $selisihWaktu = $shiftDay->cin1->diff($cin1);
                                    $waktuTelat = ($selisihWaktu->h) + (round($selisihWaktu->i / 30) * 0.5);

                                    Terlambat::updateOrCreate([
                                        'user_id' => $user->id,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $tanggal,
                                        'nama_karyawan'=>$jadwal->nama_karyawan
                                    ], [
                                        'waktu_terlambat' => $waktuTelat
                                    ]);

                                    $status = 'terlambat';
                                }

                                if ($shiftDay->kode_shift == 'M') {
                                    $day2 = $day + 1;
                                    $tanggal3 = "$day2/$bulan/$tahun";
                                    $cout1 = DataPresensi::where('username', $user->nama_karyawan)
                                        ->where('eDate', $tanggal3)
                                        ->first();
                                    if($cout1!=null){
                                        $arrayData = explode(' ', $cout1->stime);
                                        $uniqueArray = array_unique($arrayData);
                                        $arrayData = implode(' ', $uniqueArray);

                                        $arrayData = explode(' ', $arrayData);
                                        $cout1 = $arrayData[0];

                                    }
                                    else{
                                        $status='alfa';
                                    }

                                    
                                }
                               

                                if ($cout1 != null) {

                                    if (!($cout1 instanceof \DateTime)) {
                                        $cout1= new \DateTime($cout1);
                                    }
                                    if (($shiftDay->cout1->getTimestamp() - $cout1->getTimestamp()) > 300) {
                                        $timeDifferent = $shiftDay->cout1->getTimestamp() - $cout1->getTimestamp();
                                        $waktuPulangCepat = round($timeDifferent / 1800) * 0.5;

                                        Potongan::updateOrCreate([
                                            'user_id' => $user->id,
                                            'shift_id' => $shiftDay->id,
                                            'tanggal' => $tanggal,
                                            'nama_karyawan'=>$jadwal->nama_karyawan
                                        ], [
                                            'waktu_potongan' => $waktuPulangCepat
                                        ]);

                                        if ($status != 'terlambat') {
                                            $status = 'potongan';
                                        } else {
                                            $status = 'terlambat dan terpotong';
                                        }
                                    }
                                } else {
                                  
                                    $status = 'alfa';
                                }
                            } else {
                          
                                $status = 'alfa';
                            }
                        }

                        if ($shiftDay->cin2 != null && $shiftDay->cout2 != null) {
                            if ($cin2 != null) {
                                if (!($cin2 instanceof \DateTime)) {
                                    $cin2= new \DateTime($cin2);
                                }
                              
                            

                                if (($cin2->getTimestamp() - $shiftDay->cin2->getTimestamp()) > 300) {
                                    $selisihWaktu = $shiftDay->cin2->diff($cin2);
                                    $waktuTelat = ($selisihWaktu->h) + (round($selisihWaktu->i / 30) * 0.5);

                                    Terlambat::create([
                                        'user_id' => $user->id,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $tanggal,
                                        'waktu_terlambat' => $waktuTelat,
                                        'nama_karyawan'=>$jadwal->nama_karyawan
                                    ]);

                                    $status = 'terlambat';
                                }

                                if($cout2==null){
                                    $hari = $day + 1;
                                    $tanggal2 = "$hari/$bulan/$tahun";
                                    $cout2 = DataPresensi::where('username', $user->nama_karyawan)
                                        ->where('eDate', $tanggal2)
                                        ->first();
                                    if($cout2!=null){
                                        $arrayData = explode(' ', $cout2->stime);
                                        $uniqueArray = array_unique($arrayData);
                                        $arrayData = implode(' ', $uniqueArray);

                                        $arrayData = explode(' ', $arrayData);
                                        $cout2 = $arrayData[0];

                                    }
                                    else{
                                        $status='alfa';
                                    }

                                    

                                }
                                
                                $cout2 = new \DateTime($cout2);

                                if (($shiftDay->cout2->getTimestamp() - $cout2->getTimestamp()) > 300) {
                                    $timeDifferent = $shiftDay->cout2->getTimestamp() - $cout2->getTimestamp();
                                    $waktuPulangCepat = round($timeDifferent / 1800) * 0.5;

                                    Potongan::updateOrCreate([
                                        'user_id' => $userId,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $tanggal,
                                        'nama_karyawan'=>$jadwal->nama_karyawan
                                    ], [
                                        'waktu_potongan' => $waktuPulangCepat
                                    ]);

                                    if ($status != 'terlambat') {
                                        $status = 'potongan';
                                    } else {
                                        $status = 'terlambat dan terpotong';
                                    }
                                    
                                } 
                            } else {
                             
                                $status = 'alfa';
                            }
                        }
                    

                    Presensi::updateOrCreate([
                        'id_karyawan' => $jadwal->user_id,
                        'nama_karyawan' => $jadwal->nama_karyawan,
                        'nama_bagian' => $jadwal->nama_bagian,
                        'cin1' => $cin1,
                        'cout1' => $cout1,
                        'cin2' => $cin2,
                        'cout2' => $cout2,
                        'status' => $status,
                        'tanggal' => $tanggal
                    ]);
                } elseif ($presensi == null && $shiftDay->kode_shift != "L") {
              
                    $status = "alfa";
                    $user = User::find($jadwal->user_id);

                    Presensi::updateOrCreate([
                        'id_karyawan' => $jadwal->user_id,
                        'nama_karyawan' => $jadwal->nama_karyawan,
                        'nama_bagian' => $jadwal->nama_bagian,
                        'cin1' => null,
                        'cout1' => null,
                        'cin2' => null,
                        'cout2' => null,
                        'status' => $status,
                        'tanggal' => $tanggal
                    ]);
                }
            }
            \odbc_close($conn);
            } else {
                echo "Koneksi gagal.";
            }
        }
        

        return route('presensi.index');

               
        
 
    }

    

    public function fetch()
    {
        $conn = odbc_connect('MS Access Database', '111', '111');
    
        if ($conn) {
            $year = 2023; // Set the desired year
            $month = 12;  // Set the desired month
    
            // Format the year and month for the SQL query
            $formattedDate = sprintf('%04d-%02d', $year, $month);

    
            $sql1 = "SELECT * FROM CHECKINOUT WHERE YEAR(CHECKTIME) = 2017";
            $result1 = odbc_exec($conn, $sql1);
    
            if ($result1) {
                $data = [];
    
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
    
                // Melakukan HTTP request ke controller lain untuk mengirim data
                $response = Http::post('http://127.0.0.1:8000/api/send', ['data' => $json]);
    
                // Mengembalikan respons dari controller lain
                return $response;
            } else {
                odbc_close($conn);
                return response()->json(['error' => 'Error executing query'], 500);
            }
        } else {
            return response()->json(['error' => 'Failed to connect to MS Access Database'], 500);
        }
    }
    

    

    
    
    

    

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    { 
        $bulan = intval($request->input('bulan'));
        $tahun = intval($request->input('tahun'));
        $jadwals = Jadwal::where('bulan', $bulan)->where('tahun',$tahun)->get();

        foreach ($jadwals as $jadwal) {
         
            for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, 1, now()->format('Y')); $day++) {
                $data = Jadwal::where("tanggal_$day", '!=', null)->where('bulan', $bulan)->pluck("tanggal_$day")->toArray();
                $dayValue = !empty($data) ? $data[0] : null;

                $dayValues["tanggal_$day"] = $dayValue;


                $tanggal = "$day/$bulan/$tahun";
                $user = User::find($jadwal->user_id);
                $presensi = DataPresensi::where('username', $user->nama_karyawan)
                    ->where('eDate', $tanggal)
                    ->first();
                $shiftDay = Shift::where('id',$jadwal->{"tanggal_$day"})->first();
            

                $datapresensi=Presensi::where('tanggal',$tanggal)->where('nama_karyawan',$user->nama_karyawan)->first();

                if($datapresensi!=null && $datapresensi->status=='izin'){
                    $waktu_izin = Carbon::parse($shiftDay->lama_waktu);

                    Izin::Create([
                        'nama_karyawan' => $user->nama_karyawan,
                        'shift_id' => $shiftDay->id,
                        'tanggal' => $tanggal,
                        'waktu_izin' => $waktu_izin->hour,
                    
                    ]);

                }

                if ($presensi != null && $shiftDay->kode_shift != "L") {
                    $status = 'tepat waktu';

                    $arrayData = explode(' ', $presensi->stime);
                    $uniqueArray = array_unique($arrayData);
                    $arrayData = implode(' ', $uniqueArray);
                    $arrayData = explode(' ', $arrayData);

                    $arraySeconds = array_map(function ($time) {
                        list($hours, $minutes) = explode(':', $time);
                        return ($hours * 3600) + ($minutes * 60);
                    }, $arrayData);

                    sort($arraySeconds);
                    $selectedSeconds = [$arraySeconds[0]];

                    foreach ($arraySeconds as $seconds) {
                        $difference = abs(end($selectedSeconds) - $seconds);

                        if ($difference >= 600) {
                            $selectedSeconds[] = $seconds;
                        }
                    }

                    $selectedTime = array_map(function ($seconds) {
                        return gmdate('H:i', $seconds);
                    }, $selectedSeconds);

                    $arrayData = implode(' ', $selectedTime);
                    $arrayData = explode(' ', $arrayData);

                    $columns = $shiftDay->cin2 != null && $shiftDay->cout2 != null ? ['cin1', 'cout1', 'cin2', 'cout2'] : ['cin1', 'cout1'];

                    foreach ($columns as $col) {
                        $shiftDay->$col = new \DateTime($shiftDay->$col);
                    }

                    $cin1 = $cout1 = $cin2 = $cout2 = null;
                    $closestIndex = null;
                   

                    foreach ($columns as $col) {
                        if (count($arrayData) != 0) {
                            $closestIndex = array_search(
                                min(array_map(
                                    function ($time) use ($shiftDay, $col) {
                                        $time = new \DateTime($time);
                                        return abs(($shiftDay->$col)->getTimestamp() - $time->getTimestamp());
                                    },
                                    $arrayData
                                )),
                                array_map(
                                    function ($time) use ($shiftDay, $col) {
                                        $time = new \DateTime($time);
                                        return abs(($shiftDay->$col)->getTimestamp() - $time->getTimestamp());
                                    },
                                    $arrayData
                                )
                            );

                            ${$col} = $arrayData[$closestIndex];
                            unset($arrayData[$closestIndex]);
                        }
                    }
                    
                    
                        

                        if ($shiftDay->cin1 != null && $shiftDay->cout1 != null) {
                            if ($cin1 != null) {

                                if (!($cin1 instanceof \DateTime)) {
                                    $cin1= new \DateTime($cin1);
                                }
                               
                           

                                if (($cin1->getTimestamp() - $shiftDay->cin1->getTimestamp()) > 300) {
                                    $selisihWaktu = $shiftDay->cin1->diff($cin1);
                                    $waktuTelat = ($selisihWaktu->h) + (round($selisihWaktu->i / 30) * 0.5);

                                    Terlambat::updateOrCreate([
                                        'user_id' => $presensi->badgenumber,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $presensi->eDate,
                                        'nama_karyawan'=>$user->nama_karyawan
                                    ], [
                                        'waktu_terlambat' => $waktuTelat
                                    ]);

                                    $status = 'terlambat';
                                }

                                if ($shiftDay->kode_shift == 'M') {
                                    $day2 = $day + 1;
                                    $tanggal3 = "$day2/$bulan/$tahun";
                                    $cout1 = DataPresensi::where('username', $user->nama_karyawan)
                                        ->where('eDate', $tanggal3)
                                        ->first();
                                    if($cout1!=null){
                                        $arrayData = explode(' ', $cout1->stime);
                                        $uniqueArray = array_unique($arrayData);
                                        $arrayData = implode(' ', $uniqueArray);

                                        $arrayData = explode(' ', $arrayData);
                                        $cout1 = $arrayData[0];

                                    }
                                    else{
                                        $status='alfa';
                                    }

                                    
                                }
                               

                                if ($cout1 != null) {

                                    if (!($cout1 instanceof \DateTime)) {
                                        $cout1= new \DateTime($cout1);
                                    }
                                    if (($shiftDay->cout1->getTimestamp() - $cout1->getTimestamp()) > 300) {
                                        $timeDifferent = $shiftDay->cout1->getTimestamp() - $cout1->getTimestamp();
                                        $waktuPulangCepat = round($timeDifferent / 1800) * 0.5;

                                        Potongan::updateOrCreate([
                                            'user_id' => $presensi->badgenumber,
                                            'shift_id' => $shiftDay->id,
                                            'tanggal' => $presensi->eDate,
                                            'nama_karyawan'=>$user->nama_karyawan
                                        ], [
                                            'waktu_potongan' => $waktuPulangCepat
                                        ]);

                                        if ($status != 'terlambat') {
                                            $status = 'potongan';
                                        } else {
                                            $status = 'terlambat dan terpotong';
                                        }
                                    }
                                } else {
                                  
                                    $status = 'alfa';
                                }
                            } else {
                          
                                $status = 'alfa';
                            }
                        }

                        if ($shiftDay->cin2 != null && $shiftDay->cout2 != null) {
                            if ($cin2 != null) {
                                if (!($cin2 instanceof \DateTime)) {
                                    $cin2= new \DateTime($cin2);
                                }
                              
                            

                                if (($cin2->getTimestamp() - $shiftDay->cin2->getTimestamp()) > 300) {
                                    $selisihWaktu = $shiftDay->cin2->diff($cin2);
                                    $waktuTelat = ($selisihWaktu->h) + (round($selisihWaktu->i / 30) * 0.5);

                                    Terlambat::create([
                                        'user_id' => $presensi->badgenumber,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $presensi->eDate,
                                        'waktu_terlambat' => $waktuTelat,
                                        'nama_karyawan'=>$user->nama_karyawan
                                    ]);

                                    $status = 'terlambat';
                                }

                                if($cout2==null){
                                    $hari = $day + 1;
                                    $tanggal2 = "$hari/$bulan/$tahun";
                                    $cout2 = DataPresensi::where('username', $user->nama_karyawan)
                                        ->where('eDate', $tanggal2)
                                        ->first();
                                    if($cout2!=null){
                                        $arrayData = explode(' ', $cout2->stime);
                                        $uniqueArray = array_unique($arrayData);
                                        $arrayData = implode(' ', $uniqueArray);

                                        $arrayData = explode(' ', $arrayData);
                                        $cout2 = $arrayData[0];

                                    }
                                    else{
                                        $status='alfa';
                                    }

                                    

                                }
                                
                                $cout2 = new \DateTime($cout2);

                                if (($shiftDay->cout2->getTimestamp() - $cout2->getTimestamp()) > 300) {
                                    $timeDifferent = $shiftDay->cout2->getTimestamp() - $cout2->getTimestamp();
                                    $waktuPulangCepat = round($timeDifferent / 1800) * 0.5;

                                    Potongan::updateOrCreate([
                                        'user_id' => $presensi->badgenumber,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $presensi->eDate,
                                        'nama_karyawan'=>$user->nama_karyawan
                                    ], [
                                        'waktu_potongan' => $waktuPulangCepat
                                    ]);

                                    if ($status != 'terlambat') {
                                        $status = 'potongan';
                                    } else {
                                        $status = 'terlambat dan terpotong';
                                    }
                                    
                                } 
                            } else {
                             
                                $status = 'alfa';
                            }
                        }
                    

                    Presensi::updateOrCreate([
                        'id_karyawan' => $jadwal->user_id,
                        'nama_karyawan' => $presensi->username,
                        'nama_bagian' => $presensi->deptname,
                        'cin1' => $cin1,
                        'cout1' => $cout1,
                        'cin2' => $cin2,
                        'cout2' => $cout2,
                        'status' => $status,
                        'tanggal' => $presensi->eDate
                    ]);
                } elseif ($presensi == null && $shiftDay->kode_shift != "L") {
              
                    $status = "alfa";
                    $user = User::find($jadwal->user_id);

                    Presensi::updateOrCreate([
                        'id_karyawan' => $jadwal->user_id,
                        'nama_karyawan' => $user->nama_karyawan,
                        'nama_bagian' => $user->nama_bagian,
                        'cin1' => null,
                        'cout1' => null,
                        'cin2' => null,
                        'cout2' => null,
                        'status' => $status,
                        'tanggal' => $tanggal
                    ]);
                }
            }
        }

        return route('presensi.index');
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
