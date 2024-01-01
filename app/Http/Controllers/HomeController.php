<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Arsip;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;

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

            $countUsers = User::count();
            $countArsips = Arsip::count();
            $countSuratMasuk = SuratMasuk::count();
            $countSuratKeluar = SuratKeluar::count();

            // // Mengambil data surat masuk
            // $suratMasukData = SuratMasuk::selectRaw('MONTH(created_at) as month, COUNT(*) as surat_masuk')
            //     ->groupByRaw('MONTH(created_at)')
            //     ->get();

            // // Mengambil data surat keluar
            // $suratKeluarData = SuratKeluar::selectRaw('MONTH(created_at) as month, COUNT(*) as surat_keluar')
            //     ->groupByRaw('MONTH(created_at)')
            //     ->get();

            // // Menggabungkan data surat masuk dan keluar berdasarkan bulan
            // $suratData = $suratMasukData->merge($suratKeluarData)->groupBy('month')->all();
            return view('admin.index')
                ->with(compact('countUsers', 'countArsips', 'countSuratMasuk', 'countSuratKeluar'));
                // ->with('suratDataJson', json_encode($suratData));

        } else if (Auth::user()->role == 2) {
            $countUsers = User::count();
            $countArsips = Arsip::count();
            $countSuratMasuk = SuratMasuk::count();
            $countSuratKeluar = SuratKeluar::count();
            // Mengambil data surat masuk
            // $suratMasukData = SuratMasuk::selectRaw('MONTH(created_at) as month, COUNT(*) as surat_masuk')
            //     ->groupByRaw('MONTH(created_at)')
            //     ->get();

            // // Mengambil data surat keluar
            // $suratKeluarData = SuratKeluar::selectRaw('MONTH(created_at) as month, COUNT(*) as surat_keluar')
            //     ->groupByRaw('MONTH(created_at)')
            //     ->get();

            // // Menggabungkan data surat masuk dan keluar berdasarkan bulan
            // $suratData = $suratMasukData->merge($suratKeluarData)->groupBy('month')->all();
            // return view('kepalabagian.index', compact('countUsers', 'countArsips', 'countSuratMasuk', 'countSuratKeluar'));
            return view('kepalabagian.index')
                ->with(compact('countUsers', 'countArsips', 'countSuratMasuk', 'countSuratKeluar'));
                // ->with('suratDataJson', json_encode($suratData));
        } else if (Auth::user()->role == 3) {
            return view('karyawan.index');
        }
    }
}
