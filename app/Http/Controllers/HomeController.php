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

            // /
            return view('admin.index')
                ->with(compact('countUsers', 'countArsips', 'countSuratMasuk', 'countSuratKeluar'));
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
