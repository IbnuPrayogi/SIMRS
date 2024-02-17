<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\User;
use App\Models\Check;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StorePresensiRequest;
use App\Http\Requests\UpdatePresensiRequest;

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

        $url = 'http://127.0.0.1:8001/presensi/fetch/'.$bulan.'/'.$tahun;
        
        $response = Http::withOptions(['timeout' => 120])->get($url);

        if(intval(now()->format('m'))==$bulan && intval(now()->format('Y'))==$tahun){
            $limit= intval(now()->format('d'));
        }
        else{
            $limit=cal_days_in_month(CAL_GREGORIAN, 1, now()->format('Y'));
        }
 

        $jadwals = Jadwal::where('bulan', $bulan)->where('tahun',$tahun)->get();
       
      
        foreach ($jadwals as $jadwal) {
          
            

            for ($day = 1; $day <= $limit; $day++) {
                $data = Jadwal::where("tanggal_$day", '!=', null)->where('bulan', $bulan)->pluck("tanggal_$day")->toArray();
                $dayFormatted = str_pad($day, 2, '0', STR_PAD_LEFT);
                $tanggal = "$day/$bulan/$tahun";
                $date="$tahun-$bulan-$dayFormatted";

                $user = User::where('nama_karyawan',$jadwal->nama_karyawan)->first();

                $shiftDay = Shift::where('id',$jadwal->{"tanggal_$day"})->first();

                $presensiData = Check::where('nama_karyawan', $user->nama_karyawan)
                    ->whereDate('waktu', $date)
                    ->groupBy(DB::raw('TIME(waktu)')) // Menggunakan fungsi DATE untuk mengambil tanggal dari timestamp
                    ->pluck(DB::raw('TIME(waktu)'));

                // Menggabungkan tanggal-tanggal menjadi string yang dipisahkan oleh spasi
                $combinedDates = implode(' ', $presensiData->toArray());

                // Output string yang berisi tanggal-tanggal presensi
                $presensi=$combinedDates;
            
            

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
        }
        

        return redirect()->route('presensi.index');

               
     
 
    }

    

    public function fetch($bulan,$tahun)
    {
 
        $conn = odbc_connect('MS Access Database', '111', '111');
    
        if ($conn) {
            $year = intval($tahun); // Set the desired year
            $month = intval($bulan);  // Set the desired month
            $sql1 = "SELECT CHECKINOUT.CHECKTIME, CHECKINOUT.USERID, 
                 (SELECT NAME FROM USERINFO WHERE USERID = CHECKINOUT.USERID) AS UserName
                    FROM CHECKINOUT 
                    WHERE YEAR(CHECKINOUT.CHECKTIME) = $year AND MONTH(CHECKINOUT.CHECKTIME) = $month";
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
                $axiosResponse = Http::withOptions(['timeout' => 120])->asJson()->post('http://127.0.0.1:8003/api/kirimdata/presensi', ['data1' => $json]);
              
                return $axiosResponse;
            } else {
                odbc_close($conn);
                return response()->json(['error' => 'Error executing query'], 500);
            }
        } else {
            return response()->json(['error' => 'Failed to connect to MS Access Database'], 500);
        }
    }

    public function fetchData($bulan, $tahun)
    {
        
        try {
            
            // Ganti URL dengan URL dari variabel $url
            $url = 'http://127.0.0.1:8001/presensi/fetch/'.$bulan.'/'.$tahun;
        
            // Menggunakan Http::get untuk mendapatkan data
            $response = Http::withOptions(['timeout' => 120])->get($url);
        
            // Lakukan sesuatu dengan respons yang diterima
            dd($response);
        } catch (\Exception $e) {
         
            dd(['error' => 'Terjadi kesalahan saat mengambil data.']);
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
