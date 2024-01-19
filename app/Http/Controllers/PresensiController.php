<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Potongan;
use App\Models\Presensi;
use App\Models\Terlambat;
use App\Models\DataPresensi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StorePresensiRequest;
use App\Http\Requests\UpdatePresensiRequest;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $shifts = Shift::all();
        $jadwal = Jadwal::all();
        $presensi = Presensi::all();

        return View::make('admin.presensi.index', compact('users', 'shifts','jadwal','presensi'));
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
    public function store(Request $request)
    { 
        $bulan = intval($request->input('bulan'));
        $tahun = intval($request->input('tahun'));
        $jadwals = Jadwal::where('bulan', $bulan)->get();

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
                
                $data = Presensi::where('username', $user->nama_karyawan)
                    ->where('eDate', $tanggal)
                    ->first();

                $shiftDay = Shift::find($dayValue);

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

                        if ($shiftDay->cin1 != null && $shiftDay->cout1 != null) {
                            if ($cin1 != null) {
                                $cin1 = new \DateTime($cin1);

                                if (($cin1->getTimestamp() - $shiftDay->cin1->getTimestamp()) > 300) {
                                    $selisihWaktu = $shiftDay->cin1->diff($cin1);
                                    $waktuTelat = ($selisihWaktu->h) + (round($selisihWaktu->i / 30) * 0.5);

                                    Terlambat::updateOrCreate([
                                        'user_id' => $presensi->badgenumber,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $presensi->eDate,
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

                                    $arrayData = explode(' ', $cout1->stime);
                                    $uniqueArray = array_unique($arrayData);
                                    $arrayData = implode(' ', $uniqueArray);

                                    $arrayData = explode(' ', $arrayData);
                                    $cout1 = $arrayData[0];
                                }

                                if ($cout1 != null) {
                                    $cout1 = new \DateTime($cout1);

                                    if (($shiftDay->cout1->getTimestamp() - $cout1->getTimestamp()) > 300) {
                                        $timeDifferent = $shiftDay->cout1->getTimestamp() - $cout1->getTimestamp();
                                        $waktuPulangCepat = round($timeDifferent / 1800) * 0.5;

                                        Potongan::updateOrCreate([
                                            'user_id' => $presensi->badgenumber,
                                            'shift_id' => $shiftDay->id,
                                            'tanggal' => $presensi->eDate,
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
                                $cin2 = new \DateTime($cin2);

                                if (($cin2->getTimestamp() - $shiftDay->cin2->getTimestamp()) > 300) {
                                    $selisihWaktu = $shiftDay->cin2->diff($cin2);
                                    $waktuTelat = ($selisihWaktu->h) + (round($selisihWaktu->i / 30) * 0.5);

                                    Terlambat::create([
                                        'user_id' => $presensi->badgenumber,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $presensi->eDate,
                                        'waktu_terlambat' => $waktuTelat
                                    ]);

                                    $status = 'terlambat';
                                }

                                if($cout2==null){
                                    $hari = $day + 1;
                                    $tanggal2 = "$hari/$bulan/$tahun";
                                    $cout2 = DataPresensi::where('username', $user->nama_karyawan)
                                        ->where('eDate', $tanggal2)
                                        ->first();

                                    $arrayData = explode(' ', $cout2->stime);
                                    $uniqueArray = array_unique($arrayData);
                                    $arrayData = implode(' ', $uniqueArray);

                                    $arrayData = explode(' ', $arrayData);
                                    $cout2 = $arrayData[0];

                                }
                                
                                $cout2 = new \DateTime($cout2);

                                if (($shiftDay->cout2->getTimestamp() - $cout2->getTimestamp()) > 300) {
                                    $timeDifferent = $shiftDay->cout2->getTimestamp() - $cout2->getTimestamp();
                                    $waktuPulangCepat = round($timeDifferent / 1800) * 0.5;

                                    Potongan::updateOrCreate([
                                        'user_id' => $presensi->badgenumber,
                                        'shift_id' => $shiftDay->id,
                                        'tanggal' => $presensi->eDate,
                                    ], [
                                        'waktu_potongan' => $waktuPulangCepat
                                    ]);

                                    if ($status != 'terlambat') {
                                        $status = 'potongan';
                                    } else {
                                        $status = 'terlambat dan terpotong';
                                    }
                                    
                                } else {
                                    $status = 'alfa';
                                }
                            } else {
                                $status = 'alfa';
                            }
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
