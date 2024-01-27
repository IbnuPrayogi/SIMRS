<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Arsip;
use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Terlambat;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 1) {

            $jumlahAdmin = User::where('role',1)->count();
            $jumlahUser=User::where('role',3)->count();
            $jumlahShift = Shift::count();
            $jumlahTerlambat = Terlambat::count();
            $dataTerlambat=Terlambat::take(4)->get();
            $today= Carbon::now()->day;
            $month=Carbon::now()->month;
            $year=Carbon::now()->year;
            $idPagi = Shift::where('kode_shift', 'P')->pluck('id');
            $idSiang=Shift::where('kode_shift',"S")->pluck('id');
            $idMalam=Shift::where('kode_shift',"M")->pluck('id');
            $idPagiMalam=Shift::where('kode_shift',"PM")->pluck('id');
            $idPagiSiang=Shift::where('kode_shift',"PS")->pluck('id');
            $pagi=Jadwal::whereIn("tanggal_{$today}",$idPagi)->where('bulan',$month)->where('tahun',$year)->count();
            $siang=Jadwal::whereIn("tanggal_{$today}",$idSiang)->where('bulan',$month)->where('tahun',$year)->count();
            $malam=Jadwal::whereIn("tanggal_{$today}",$idMalam)->where('bulan',$month)->where('tahun',$year)->count();
            $pagimalam=Jadwal::whereIn("tanggal_{$today}",$idPagiMalam)->where('bulan',$month)->where('tahun',$year)->count();
            $pagisore=Jadwal::whereIn("tanggal_{$today}",$idPagiSiang)->where('bulan',$month)->where('tahun',$year)->count();
            $dynamicsData=[$pagi,$siang,$malam,$pagimalam,$pagisore];
       
     
            // /
            return view('admin.index')
                ->with(compact(
                    'jumlahAdmin',
                    'jumlahUser',
                    'jumlahShift',
                    'jumlahTerlambat',
                    'pagi',
                    'siang',
                    'malam',
                    'pagimalam',
                    'pagisore',
                    'dynamicsData',
                    'dataTerlambat'
                ));
                // ->with('suratDataJson', json_encode($suratData));

        } else if (Auth::user()->role == 2) {
            $countUsers = User::count();
            $countArsips = Arsip::count();
            $countSuratMasuk = SuratMasuk::count();
            $countSuratKeluar = SuratKeluar::count();
         
            return view('kepalabagian.index')
                ->with(compact('countUsers', 'countArsips', 'countSuratMasuk', 'countSuratKeluar'));
                // ->with('suratDataJson', json_encode($suratData));
        } else if (Auth::user()->role == 3) {
            return view('karyawan.index');
        }
    }
}
