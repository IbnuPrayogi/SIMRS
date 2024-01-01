<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


use App\Models\User;

class ProfileAdminController extends Controller
{

    public function index()
    {
        // $user=User::find($id);
        return view('admin.Profile.index');
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }
    public function EditPassword()
    {
        return view('admin.Profile.editPassword');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|different:password_lama',
        ]);

        // $user = auth()->user();

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi lama tidak cocok.');

        }
        // DD($request->password_baru,$user->password);
        $user->password = $request->password_baru;
        $user->save();
        // $user->update(['password' => Hash::make($request->password_baru)]);
        return redirect()->route('profile.user')->with('success', 'Profile berhasil diubah.');
    }

    public function edit(string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'nama_karyawan' => 'required',
            'alamat' => 'required',
            'nomor_hp' => 'required',
        ]);

        $validatedData = $request->validate([
            'foto' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
            'tanda_tangan' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
        ]);


        $user->nama_karyawan = $request->input('nama_karyawan');
        $user->alamat = $request->input('alamat');
        $user->nomor_hp = $request->input('nomor_hp');

        if ($request->hasFile('foto')) {
            // Delete old profile photo if it exists
            if ($user->foto) {
                File::delete(public_path('assets/profil/' . $user->foto));
            }
            $file1 = $validatedData[('foto')];
            $filename1 =  $file1->getClientOriginalName();
            // File upload location
            $location1 = '../public/assets/profil/';

            $file1->move(public_path($location1), $filename1);
            $user->foto = $filename1;
        }
        // Update tanda_tangan if provided
        if ($request->hasFile('tanda_tangan')) {
            // Delete old profile photo if it exists
            if ($user->foto) {
                File::delete(public_path('assets/ttd/' . $user->tanda_tangan));
            }

            $file2 = $validatedData[('tanda_tangan')];

            $filename2 = $file2->getClientOriginalName();

            $location2 = '../public/assets/ttd/';
            $file2->move(public_path($location2), $filename2);
            $user->tanda_tangan = $filename2;
        }

        // Save the updated user
        $user->save();
        Session::flash('success', 'Profile Berhasil Diubah');
        return redirect()->route('profile.user')->with('success', 'profile berhasil diupdate.');
    }
}
